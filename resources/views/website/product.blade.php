@extends('website.app')
@section('content')
<!--=== Content Part infoblock ===-->
<main id="product" class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-sm-push-8">
			<div class="image">
				<img class="img-responsive" src="{!! ImgHelper::get_cached($product->image, config('maguttiCms.image.medium')) !!}" alt="">
			</div>
		</div>
		<div class="col-xs-12 col-sm-8 col-sm-pull-4 mb20">
			<h1>{{$product->title}}</h1>
			<h5>{{trans('store.product.code')}}: {{$product->code}}</h5>
			{!!$product->description!!}

			@if (StoreHelper::isStoreEnabled())
				{{trans('store.product.price')}}: {{StoreHelper::formatProductPrice($product)}}
				<hr>
				<input class="form-control cart-item-quantity" type="number" name="quantity" value="1" min="1" autocomplete="off">
				<a href="" class="btn btn-primary cart-item-add"
				    data-product-code="{{$product->code}}"
				    data-quantity="1">
					{{trans('store.items.add')}}
				</a>
			@endif
		</div>
	</div>
</main>
@endsection
