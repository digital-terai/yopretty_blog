<?php namespace App\maguttiCms\Tools;

use Auth;
use App\Address;
use App\Cart;
use App\CartItem;
use App\Order;
use App\OrderItem;
use App\Payment;
use App\PaymentMethod;
use App\SpecialPrice;
use Illuminate\Http\Request;
use App\maguttiCms\PayPal\GFExpressCheckout;

class StoreHelper {
	/////	STORE	/////

	// store functionality
	public static function isStoreEnabled()
	{
		return config('maguttiCms.store.enabled');
	}
	public static function isShippingEnabled()
	{
		return config('maguttiCms.store.shipping.enabled');
	}
	public static function formatPrice($price)
	{
		$formatted_price = number_format(floatval($price), config('maguttiCms.store.formatting.decimals'), config('maguttiCms.store.formatting.decimal_separator'), config('maguttiCms.store.formatting.thousands_separator'));

		if (config('maguttiCms.store.formatting.prepend_currency')) {
			$formatted_price = config('maguttiCms.store.currency_symbol').' '.$formatted_price;
		}
		if (config('maguttiCms.store.formatting.append_currency')) {
			$formatted_price .= ' '.config('maguttiCms.store.currency_symbol');
		}

		return $formatted_price;
	}

	/////	PRODUCTS	/////

	// product display
	public static function canViewPrices()
	{
		if (self::isStoreEnabled() && (Auth::user() || !config('maguttiCms.store.private_prices'))) {

		}
		return true;
	}
	public static function getProductPrice($product)
	{
		if ($user = Auth::user()) {
			if ($user->list_code) {
				$list_price = SpecialPrice::where('list_code', $user->list_code)->where('product_code', $product->code)->first();
				if ($list_price) {
					return $list_price->price;
				}
			}
		}

		return floatval($product->price);
	}
	public static function formatProductPrice($product, $quantity = 0)
	{
		$quantity = max($quantity, 1);

		$price = self::getProductPrice($product);
		if (!$price)
			$price = 0;

		return self::formatPrice($price * $quantity);
	}
	public static function hasFreeShipping($product)
	{
		$threshold = config('maguttiCms.store.shipping.free_threshold');
		return $threshold && self::getProductPrice() > $threshold;
	}

	/////	CART	/////

	// cart display
	public static function getCartTotal($cart = false)
	{
		if (!$cart)
			$cart =  self::getSessionCart();
		if ($cart) {
			$cart_items = $cart->cart_items()->with('product')->get();
			$total = 0;
			foreach ($cart_items as $_item) {
				$total += self::getProductPrice($_item->product) * $_item->quantity;
			}
			return round($total, 2);
		}
		else
			return 0;
	}
	public static function formatCartTotal()
	{
		$total = self::getCartTotal();
		return self::formatPrice($total);
	}
	public static function getCartItemCount($cart = false)
	{
		if (!$cart)
			$cart = self::getSessionCart();
		if ($cart)
			return $cart->cart_items()->sum('quantity');
		else
			return 0;
	}

	// cart retrieving
	public static function getSessionCart()
	{
		if (session()->has('cart')) {
			$id = session('cart');
			$cart = Cart::where('status', CART_NEW)->where('id', $id)->first();
			return ($cart)? $cart: false;
		}
		else
			return false;
	}
	// cart storing
	public static function setSessionCart($cart)
	{
		session()->put('cart', $cart->id);
	}
	// cart flushing
	public static function forgetSessionCart()
	{
		session()->forget('cart');
	}

	// get open cart
	public static function getUserCart()
	{
		if ($user = Auth::user())
			$cart = Cart::where('status', CART_NEW)->where('user_id', $user->id)->first();
		return ($cart)? $cart: false;
	}

	// open a new cart and set it to session
	public static function cartCreate()
	{
		if ($user = Auth::user())
			$cart = Cart::create(['user_id' => $user->id]);
		else
			$cart = Cart::create([]);

		self::setSessionCart($cart);

		return $cart;
	}

	/////	CART ITEMS	/////

	// add item from cart
	public static function cartItemAdd($product_code, $quantity, $product_model_code = '')
	{
		$cart = self::getSessionCart();
		if (!$cart)
			$cart = self::cartCreate();

		$cart_item = CartItem::firstOrCreate([
			'cart_id'            => $cart->id,
			'product_code'       => $product_code,
			'product_model_code' => $product_model_code,

		]);
        $cart_item->increment('quantity',(int)$quantity);

		if ($cart_item)
			return [
				'cart'       => $cart,
				'cart_item'  => $cart_item,
				'cart_count' => self::getCartItemCount($cart)
			];
		else
			return false;
	}

	// remove item from cart
	public static function cartItemRemove($cart_item_id)
	{
		$cart = self::getSessionCart();
		if ($cart) {
			$cart_item = CartItem::find($cart_item_id);
			if ($cart_item && $cart_item->cart_id == $cart->id) {
				$cart_item->delete();
				return [
					'cart'       => $cart,
					'cart_count' => self::getCartItemCount($cart)
				];
			}
			else
				return false;
		}
		else
			return false;
	}

	// empty the cart
	public static function cartClear()
	{
		$cart = self::getSessionCart();
		if ($cart) {
			$cart->cart_items()->delete();
			return true;
		}
		else
		return false;
	}

	public static function cartItemCleanQuantities($cart)
	{
		foreach ($cart->cart_items as $_item) {
			$_item->quantity  = Max($_item->quantity, 1);
			$_item->save();
		}
	}

	/////	COSTS	/////

	// standard shipping calculation
	public static function calcShipping($cart, $products_cost, $address)
	{
		if (self::isShippingEnabled()) {
			$threshold = config('maguttiCms.store.shipping.free_threshold');
			if ($threshold && $products_cost > $threshold) {
				$cost = 0;
			}
			else {
				if (config('maguttiCms.store.shipping.use_service')) {
					$cost = self::getShippingFromService($cart, $address);
				}
				else {
					$cost = $products_cost * config('maguttiCms.store.shipping.percentage') + config('maguttiCms.store.shipping.fixed');
				}
			}
			return round($cost, 2);
		}
		else
			return 0;
	}

	// custom shipping calculation
	public static function getShippingFromService($cart, $address)
	{
		// write your own api call to external services like UPS, DHL and TNT
		return 100;
	}

	// vat calculation
	public static function calcVat($cart, $products_cost, $shipping_cost)
	{
		$vat = 0;
		$percentage = config('maguttiCms.store.vat.percentage');
		if (config('maguttiCms.store.vat.apply_to_products'))
			$vat += $products_cost * $percentage;
		if (config('maguttiCms.store.vat.apply_to_shipping'))
			$vat += $shipping_cost * $percentage;

		return round($vat, 2);
	}

	/////	ORDERS	/////

	// order cost calculation
	public static function calcCosts($cart, $address)
	{
		$products = self::getCartTotal($cart);
		$shipping = self::calcShipping($cart, $products, $address);
		$vat = self::calcVat($cart, $products, $shipping);
		$total = $products + $shipping + $vat;

		return [
			'products' => $products,
			'shipping' => $shipping,
			'vat' => $vat,
			'total' => $total,
		];
	}

	// order creation
	public static function orderCreate($cart, $billing_address_id, $shipping_address_id)
	{
		$cart_items = $cart->cart_items()->with('product')->get();
		$address = Address::find($shipping_address_id);
		$costs = self::calcCosts($cart, $address);

		// order creation
		$order = Order::create([
			'user_id'             => $cart->user_id,
			'cart_id'             => $cart->id,
			'products_cost'       => $costs['products'],
			'shipping_cost'       => $costs['shipping'],
			'vat_cost'            => $costs['vat'],
			'total_cost'          => $costs['total'],
			'billing_address_id'  => $billing_address_id,
			'shipping_address_id' => $shipping_address_id,
			'token'               => Str::random(32)
		]);

		$cart->status = CART_SENT;
		$cart->save();

		// order items creation
		foreach ($cart_items as $_item) {
			OrderItem::create([
				'order_id'           => $order->id,
				'cartitem_id'        => $_item->id,
				'product_code'       => $_item->product_code,
				'product_model_code' => $_item->product_model_code,
				'quantity'           => $_item->quantity,
				'price'              => self::getProductPrice($_item->product)
			]);
		}

		return $order;
	}

	// get order by token
	public static function getOrderByToken($token)
	{
		$order = Order::where('token', $token)->with(['payment', 'billing_address', 'shipping_address'])->first();

		return ($order)? $order: false;
	}

	/////	PAYMENTS	/////

	// retrieve available payment methods
	public static function getPaymentMethods()
	{
		$payment_methods = PaymentMethod::active()->get();

		return $payment_methods;
	}

	// create payment for order
	public static function createPayment($order_id, $payment_method_id)
	{
		$payment = Payment::create([
			'order_id' => $order_id,
			'payment_method_id' => $payment_method_id,
		]);

		return ($payment)? $payment: false;
	}

	public static function getPaypalPaymentOptions()
	{
		$options = [
		    'BRANDNAME' => config('maguttiCms.website.options.app.name'),
		    'LOGOIMG' => asset('/website/images/logo.png'),
		    'CHANNELTYPE' => 'Merchant',
			'SOLUTIONTYPE' => 'Sole'
		];

		return $options;
	}

	public static function getPaypalPaymentData($order, $id)
	{
		$data = [];
		$data['items'] = [];

		$vat_percentage = 1 + config('maguttiCms.store.vat.percentage');
		$items_total = 0;
		foreach ($order->order_items()->with('product')->get() as $_item) {
			$price = self::getProductPrice($_item->product);
			$items_total += $price * $_item->quantity;
		}

		if (config('maguttiCms.store.vat.apply_to_products')) {
			$items_total *= $vat_percentage;
			$items_total = round($items_total, 2);
		}
		$data['items'][] = [
			'name' => trans('store.paypal.items_total'),
			'price' => $items_total,
			'qty' => $_item->quantity
		];

		// $data['invoice_id'] = $order->id;
		$data['invoice_id'] = $id;
		$data['invoice_description'] = "Order #{$id} Invoice";
		$data['return_url'] = url_locale('/order-payment-confirm/'.$order->token);
		$data['cancel_url'] = url_locale('/order-payment-cancel/'.$order->token);

		$data['products_cost'] = $items_total;

		if (config('maguttiCms.store.vat.apply_to_shipping'))
			// $data['shipping_cost'] = 0;
			$data['shipping_cost'] = round($order->shipping_cost * $vat_percentage, 2);
		else
			$data['shipping_cost'] = $order->shipping_cost;

		$data['total'] = $order->total_cost;
		if (self::isShippingEnabled()) {
			$address = $order->shipping_address;
			$data['noshipping'] = 0;
			$data['ship_to_name'] = $order->user->name;
			$data['ship_to_street'] = $address->street.', '.$address->number;
			$data['ship_to_city'] = $address->city;
			$data['ship_to_state'] = $address->province;
			$data['ship_to_zip'] = $address->zip_code;
			$data['ship_to_country_code'] = $address->country->iso_code;
			$data['ship_to_country_name'] = $address->country->name;
			$data['ship_phone_number'] = $address->phone;
		}
		else {
			$data['noshipping'] = 1;
		}

		return $data;
	}

	public static function processPayment($payment)
	{
		switch ($payment->payment_method->code) {
			case 'bank': return false; break;
			case 'paypal':
				$provider = new GFExpressCheckout;
				$provider->setCurrency(config('maguttiCms.store.currency'));
				$options = self::getPaypalPaymentOptions();
				$order = $payment->order;
				$payment->code = $order->id.'-'.Str::random(10);
				$payment->save();
				$data = self::getPaypalPaymentData($order, $payment->code);
				$response = $provider->addOptions($options)->setExpressCheckout($data);
				if (in_array(strtoupper($response['ACK']), ['SUCCESS','SUCCESSWITHWARNING'])) {
					return [
						'status' => 'ok',
						'text' => $response['paypal_link']
					];
	            }
	            else {
	                $payment->notes = $response['L_LONGMESSAGE0'];
	                $payment->save();
					$payment->delete();

	                return [
						'status' => 'fail',
						'text' => $response['L_LONGMESSAGE0']
					];
		        }
				break;
		}
	}

	public static function getCancelPayment($payment)
	{
		$payment->delete();
	}

	public static function confirmPayment($payment, $request)
	{
		switch ($payment->payment_method->code) {
			case 'bank':
				break;
			case 'paypal':
				$token = $request->get('token');
				$PayerID = $request->get('PayerID');
				$order = $payment->order;
				$data = self::getPaypalPaymentData($order, $payment->code);
				$provider = new GFExpressCheckout;
				$provider->setCurrency(config('maguttiCms.store.currency'));
				$response = $provider->getExpressCheckoutDetails($token);
				if (in_array(strtoupper($response['ACK']), ['SUCCESS','SUCCESSWITHWARNING'])) {
		            // Perform transaction on PayPal
		            $payment_status = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
		            // If the transaction is successfully completed
		            if (in_array(strtoupper($payment_status['ACK']), ['SUCCESS','SUCCESSWITHWARNING'])) {
						$payment->transaction = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];
						$payment->notes = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
						$payment->is_paid = 1;
						$payment->save();

		                return false;
		            }
		            else {
		                $payment->notes = $payment_status['L_LONGMESSAGE0'];
		                $payment->save();
						$payment->delete();

		                return $payment_status['L_LONGMESSAGE0'];
		            }
		        }
				break;
		}
	}
}
