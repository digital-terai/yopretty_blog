@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <h1>{{trans('store.cart.title')}}</h1>
	@if ($cart_items->count())
		<table class="table">
			<thead>
				<tr>
					<th class="width-10">{{trans('store.cart.table.code')}}</th>
					<th>{{trans('store.cart.table.name')}}</th>
					<th class="width-10">{{trans('store.cart.table.quantity')}}</th>
					<th class="width-10">{{trans('store.cart.table.price')}}</th>
					<th class="width-10">{{trans('store.cart.table.total')}}</th>
					<th class="width-10"></th>
					<th class="width-10">{{trans('store.cart.table.actions')}}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($cart_items as $_item)
					<tr class="cart-item-block" data-price="{{StoreHelper::getProductPrice($_item->product)}}">
						<td>
							<a href="{{$_item->product->getPermalink()}}">
								{{$_item->product->code}}
							</a>
						</td>
						<td>
							<a href="{{$_item->product->getPermalink()}}">
								{{$_item->product->title}}
							</a>
						</td>
						<td>
							<input
							type="number"
							class="form-ghost cart-item-quantity cart-preview"
							value="{{$_item->quantity}}"
							data-id="{{$_item->id}}"
							data-model="CartItem"
							data-field="quantity"
							autocomplete="off"
							min="1"
							>
						</td>
						<td>{{StoreHelper::formatProductPrice($_item->product)}}</td>
						<td class="cart-item-total">{{StoreHelper::formatProductPrice($_item->product, $_item->quantity)}}</td>
						<td>
							<img src="{{ImgHelper::get_cached($_item->product->image, ['w' => 100, 'h' => 100, 'q' => 50])}}" alt="">
						</td>
						<td>
							<a href="" class="cart-item-remove" data-id="{{$_item->id}}">
								{{icon('trash')}}
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th>{{trans('store.cart.total')}}</th>
					<th></th>
					<th></th>
					<th class="cart-total">{{StoreHelper::formatCartTotal()}}</th>
					<th></th>
					<th></th>
				</tr>
			</tfoot>
		</table>
		<hr>
		<div id="cart-buttons">
			<a class="btn btn-primary" href="{{url_locale('store')}}">
				{{trans('store.cart.back')}}
			</a>
			<a class="btn btn-primary" href="{{url_locale('order-submit')}}">
				{{trans('store.cart.buy')}}
			</a>
		</div>
	@else
		<div class="alert alert-info">
			{{trans('store.cart.empty')}}
		</div>
	@endif
</main>
@endsection
