@extends('website.app')
@section('content')
	<main class="container">
		<h1>{{$article->title}}</h1>
		{!! $article->description !!}
	</main>
@endsection
