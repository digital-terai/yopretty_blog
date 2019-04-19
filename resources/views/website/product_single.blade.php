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
			{!!$product->description!!}
			category {{ optional($product->category)->title }}
		</div>
	</div>
</main>
@endsection
