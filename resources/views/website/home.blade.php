@extends('website.app')
@section('content')
{{-- @include('website.partials.carousel') --}}
<!--=== Content Part infoblock ===-->
<main class="container">
    <h1>{!! $article->title !!}</h1>

    <h1>News</h1>
@include('website.news.home')

    <h2>{!! $article->subtitle !!}</h2>
	{!! $article->description !!}
</main>
@endsection
