<?php
return [

		'contacts' => [
			'name'	  => 'required',
			'surname' => 'required',
            'subject' => 'required',
			'message' => 'required',
			'privacy' => 'required',
			'email'   => 'required|Between:3,64|Email',
		],

		'newsletter' => [
			'email' => 'required|Between:3,64|Email|unique:newsletters',
		],

		'cart-item-add' => [
			'product_code' => 'required',
			'quantity'     => 'required|numeric|min:1'
		],

		'cart-item-remove' => [
			'cart_item_id' => 'required',
		],

		'order-submit' => [
			'cart_id'             => 'required|numeric',
			'billing_address_id'  => 'required|numeric',
			'shipping_address_id' => 'numeric'
		],

		'order-payment' => [
			'order_id'          => 'required|numeric',
			'payment_method_id' => 'required|numeric'
		],
        'update-ghost' => [],

		'address-new' => [
			'street'     => 'required',
			'number'     => 'required',
			'zip_code'   => 'required',
			'city'       => 'required',
			'province'   => 'required',
			'country_id' => 'required|numeric',
			'email'      => 'email'
		]
];
