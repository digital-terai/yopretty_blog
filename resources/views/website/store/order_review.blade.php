@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <h1>{{trans('store.order.title')}}</h1>
	@include('flash::notification')
	<h3>{{trans('store.order.resume')}}</h3>
	<table class="table">
		<thead>
			<tr>
				<th class="width-10">{{trans('store.cart.table.code')}}</th>
				<th>{{trans('store.cart.table.name')}}</th>
				<th class="width-10">{{trans('store.cart.table.quantity')}}</th>
				<th class="width-10">{{trans('store.cart.table.price')}}</th>
				<th class="width-10">{{trans('store.cart.table.total')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($order_items as $_item)
				<tr data-price="{{StoreHelper::getProductPrice($_item->product)}}">
					<td>
						{{$_item->product->code}}
					</td>
					<td>
						{{$_item->product->title}}
					</td>
					<td>{{$_item->quantity}}</td>
					<td>{{StoreHelper::formatPrice($_item->price)}}</td>
					<td>{{StoreHelper::formatPrice($_item->price * $_item->quantity)}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</main>
<div class="container"><hr></div>
<section class="container">
	<h3>{{trans('store.order.addresses')}}</h3>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<label>{{trans('store.order.billing')}}</label>
			<p>
				{!!$order->billing_address->display_block!!}
			</p>
		</div>
		@if ($order->billing_address_id != $order->shipping_address_id && StoreHelper::isShippingEnabled())
			<div class="col-xs-12 col-sm-6">
				<label>{{trans('store.order.shipping')}}</label>
				<p>
					{!!$order->shipping_address->display_block!!}
				</p>
			</div>
		@endif
	</div>
</section>
<div class="container"><hr></div>
<section class="container">
	<h3>{{trans('store.order.totals')}}</h3>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<table class="table">
				<tbody>
					<tr>
						<th>{{trans('store.order.products_cost')}}</th>
						<td>{{StoreHelper::formatPrice($order->products_cost)}}</td>
					</tr>
					@if (StoreHelper::isShippingEnabled())
						<tr>
							<th>{{trans('store.order.shipping_cost')}}</th>
							<td>{{StoreHelper::formatPrice($order->shipping_cost)}}</td>
						</tr>
					@endif
					@if (config('maguttiCms.store.vat.apply_to_products') || config('maguttiCms.store.vat.apply_to_shipping'))
						<tr>
							<th>{{trans('store.order.vat_cost')}}</th>
							<td>{{StoreHelper::formatPrice($order->vat_cost)}}</td>
						</tr>
					@endif
				</tbody>
				<tfoot>
					<tr>
						<th>{{trans('store.order.total_cost')}}</th>
						<th>{{StoreHelper::formatPrice($order->total_cost)}}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</section>
<div class="container"><hr></div>
<section class="container">
	<h3>{{trans('store.order.payment')}}</h3>
	@if ($order->payment)
		{{$order->payment->payment_method->title}} -
		@if ($order->payment->is_paid)
			{{trans('store.payment.paid')}}
		@else
			{{trans('store.payment.unpaid')}}
		@endif
	@else
		<form action="{{url_locale('/order-payment/')}}" method="post">
			{{ csrf_field() }}
			<input type="hidden" name="order_id" value="{{$order->id}}">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					@foreach ($payment_methods as $_method)
						<div class="form-radio">
							<input type="radio" name="payment_method_id" value="{{$_method->id}}">
							<label>{{$_method->title}}</label>
							{{ $errors->first('privacy') }}
						</div>
					@endforeach
				</div>
				<div class="col-xs-12 col-sm-6">
					<button type="submit" class="btn btn-primary pull-right">
						{{trans('store.payment.pay')}}
					</button>
				</div>
			</div>
		</form>
	@endif
</section>
@endsection
