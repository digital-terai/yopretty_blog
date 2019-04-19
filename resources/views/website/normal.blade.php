@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <h1>{{ $article->title }}</h1>
    <div class="row">
        <div class="col-xs-12  {{($article->image)? 'col-md-7': '' }}">
            {!! HtmlHelper::content_part($article->description,1) !!}
            @foreach(HtmlHelper::content_part_looper($article->description) as $part)
                {!! $part !!}
            @endforeach
        </div>
        @if($article->image)
            <div class="col-md-4">
                <img src="{!! ImgHelper::get_cached($article->image, config('maguttiCms.image.medium')) !!}" alt="{{ $article->title }}" border="0" class="img-responsive">
            </div>
        @endif
    </div>
</main>
@endsection
