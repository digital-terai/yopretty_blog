@extends('website.app')
@section('content')
	<main class="container">
		<h1>{{ $category->title }}</h1>
		@foreach ($products as $_product)
			<ul>
				<li>
					<a href="{{$_product->getPermalink()}}">{{$_product->title}}</a>
				</li>
			</ul>
		@endforeach
	</main>
@endsection
