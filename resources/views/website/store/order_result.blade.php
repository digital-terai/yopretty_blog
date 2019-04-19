@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <h1>{{trans('store.payment.title')}}</h1>
	@include('flash::notification')
	<a href="{{$order->getPermalink()}}" class="btn btn-primary">
		{{trans('store.payment.back')}}
	</a>
</main>
@endsection
