@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <h1 class="text-center">{{trans('store.order.guard')}}</h1>
	<hr>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-lg-4 col-lg-push-1">
			<h3>{{trans('store.order.login')}}</h3>
			@include('website.auth.form.login')
		</div>
		<div class="col-xs-12 hidden visible-xs">
			<hr>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-4 col-lg-push-3">
			<h3>{{trans('store.order.register')}}</h3>
			@include('website.auth.form.register')
		</div>
	</div>
</main>
@endsection
