@extends('website.app')
@section('content')
	<main class="container">
		<h1>Categories</h1>
		@foreach ($categories as $_category)
			<ul>
				<li>
					<a href="{{$_category->getPermalink()}}">{{$_category->title}}</a>
				</li>
			</ul>
		@endforeach
	</main>
@endsection
