<?php

namespace App\maguttiCms\Website\Controllers;

use App\Http\Controllers\Controller;
use App\maguttiCms\Tools\StoreHelper;
use App\maguttiCms\Website\Requests\WebsiteFormRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;

class StoreController extends Controller
{
    public function __construct() {}

    public function cart() {
		$cart = StoreHelper::getSessionCart();
		if ($cart)
			$cart_items = $cart->cart_items()->list()->get();
		else
			$cart_items = collect([]);

    	return view('website.store.cart', compact('cart', 'cart_items'));
    }

    public function orderSubmit() {
		$user = Auth::user();
		if (!$user)
			return Redirect::to(url_locale('/order-login'));
		else {
			$cart = StoreHelper::getSessionCart();
			StoreHelper::cartItemCleanQuantities($cart);
			if ($cart)
				$cart_items = $cart->cart_items()->list()->get();
			else
				$cart_items = collect([]);
			$addresses = $user->addresses;

			if (!$cart) {
				session()->flash('error', trans('store.alerts.cart_invalid'));
				return back();
			}

			if (!$cart_items->count()) {
				session()->flash('error', trans('store.alerts.cart_empty'));
				return back();
			}

			return view('website.store.order_submit', compact('cart', 'cart_items', 'user', 'addresses'));
		}

    }

	public function orderLogin()
	{
		$redirectTo = url_locale('order-submit');
		$with_register = true;
		return view('website.store.order_login', compact('redirectTo', 'with_register'));
	}

	public function orderCreate(WebsiteFormRequest $request)
	{
		$user = Auth::user();

		$cart = StoreHelper::getSessionCart();
		StoreHelper::cartItemCleanQuantities($cart);

		if (!$cart || $request->cart_id != $cart->id) {
			session()->flash('error', trans('store.alerts.cart_invalid'));
			return back();
		}

		if (!$cart->cart_items->count()) {
			session()->flash('error', trans('store.alerts.cart_empty'));
			return back();
		}

		$billing_address_id = $request->billing_address_id;
		if (StoreHelper::isShippingEnabled()) {
			if ($request->shipping_address_id)
				$shipping_address_id = $request->shipping_address_id;
			else
				$shipping_address_id = $billing_address_id;
		}
		else
			$shipping_address_id = 0;

		$order = StoreHelper::orderCreate($cart, $billing_address_id, $shipping_address_id);

		if ($order) {
			StoreHelper::forgetSessionCart();
			session()->flash('success', trans('store.alerts.order_success'));
			return Redirect::to('/order-review/'.$order->token);
		}
		else {
			session()->flash('error', trans('store.alerts.order_fail'));
			return back();
		}
	}

	public function orderReview($token)
	{
		$order = StoreHelper::getOrderByToken($token);

		if ($order) {
			$order_items = $order->order_items()->list()->get();

			$payment_methods = StoreHelper::getPaymentMethods();

			return view('website.store.order_review', compact('order', 'order_items', 'payment_methods'));
		}
		else {
			return Redirect::to('/');
		}
	}

	public function orderPayment(WebsiteFormRequest $request)
	{
		$order_id = $request->order_id;
		$payment_method_id = $request->payment_method_id;
		$payment = StoreHelper::createPayment($order_id, $payment_method_id);

		if (!$payment) {
			session()->flash('error', trans('store.alerts.payment_fail'));
			return back();
		}
		$response = StoreHelper::processPayment($payment);
		if ($response['status'] == 'ok') {
			return redirect($response['text']);
		}
		else {
			$order = $payment->order;
			session()->flash('error', $response['text']);
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
	}

	public function orderCancel($token)
	{
		// session()->reflash();
		$order = StoreHelper::getOrderByToken($token);
		if ($order) {
			$payment = $order->payment;
			StoreHelper::getCancelPayment($payment);
			return Redirect::to($order->getPermalink());
		}
		else {
			return Redirect::to('/');
		}
	}

	public function orderConfirm(Request $request, $token)
	{
		$order = StoreHelper::getOrderByToken($token);
		if (!$order) {
			session()->flash('error', trans('store.alerts.payment_fail'));
			return Redirect::to('/');
		}
		$payment = $order->payment;
		if ($payment->is_paid) {
			session()->flash('error', trans('store.alerts.payment_already_paid'));
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
		$response = StoreHelper::confirmPayment($payment, $request);
		if ($response) {
			session()->flash('error', $response);
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
		else {
			session()->flash('success', trans('store.alerts.payment_success'));
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
	}

	public function orderResult($token)
	{
		// session()->reflash();
		$order = StoreHelper::getOrderByToken($token);
		if ($order) {
			$payment = $order->payment;
			return view('website.store.order_result', compact('order', 'payment'));
		}
		else {
			return Redirect::to('/');
		}
	}
}
