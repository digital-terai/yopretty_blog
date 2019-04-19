@extends('website.app')
@section('content')
	<main class="container">
		<h1>{{ $article->title }}</h1>
		@include('website.product.product_list')
	</main>
@endsection
