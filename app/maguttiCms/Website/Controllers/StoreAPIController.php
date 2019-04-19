<?php

namespace App\maguttiCms\Website\Controllers;

use App\Http\Controllers\Controller;
use App\maguttiCms\Tools\StoreHelper;
use App\maguttiCms\Website\Requests\AjaxFormRequest;

class StoreAPIController extends Controller
{
	private $response = [];

	public function __construct() {
		$this->response = [
			'alerts' => []
		];
	}

	public function storeCartItemAdd(AjaxFormRequest $request)
	{
		$product_code = $request->product_code;
		$quantity = max($request->quantity, 1);
		$product_model_code = $request->product_model_code;

		$result = StoreHelper::cartItemAdd($product_code, $quantity, $product_model_code);
		if ($result) {
			array_push($this->response['alerts'], [
				'text'	=> trans('store.alerts.add_success'),
				'type'	=> 'success',
				'time'	=> 3
			]);
			$this->response['cart_count'] = $result['cart_count'];
		}
		else {
			array_push($this->response['alerts'], [
				'text'	=> trans('store.alerts.add_fail'),
				'type'	=> 'warning',
				'time'	=> 5
			]);
		}
		return response()->json($this->response);
	}

	public function storeCartItemRemove(AjaxFormRequest $request)
	{
		$result = StoreHelper::cartItemRemove($request->get('cart_item_id'));
		if ($result) {
			array_push($this->response['alerts'], [
				'text'	=> trans('store.alerts.remove_success'),
				'type'	=> 'success',
				'time'	=> 3
			]);
			$this->response['cart_count'] = $result['cart_count'];
		}
		else {
			array_push($this->response['alerts'], [
				'text'	=> trans('store.alerts.remove_fail'),
				'type'	=> 'warning',
				'time'	=> 5
			]);
		}
		return response()->json($this->response);
	}

	public function storeOrderCalc(AjaxFormRequest $request)
	{
		$cart = StoreHelper::getSessionCart();
		if ($cart && $cart->id = $request->cart) {
			$result = StoreHelper::calcCosts($cart, $request->address);
			if ($result)
				return response()->json($result);
			else
				return response()->json(false);
		}
		return response()->json(false);
	}
}
