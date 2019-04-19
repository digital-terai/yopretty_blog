@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
	<h1>{{$article->title}}</h1>
    <div class="row">
        <div class="col-md-9">
            @foreach ($news as $_post)
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-4 mb20">
						<a href="{{$_post->getPermalink()}}">
							<img src="{!! ImgHelper::get($_post->image, config('maguttiCms.image.defaults')) !!}" alt="{{ $_post->title }}" class="img-responsive">
						</a>
					</div>
					<article class="col-xs-12 col-sm-9 col-md-8 mb20">
						<h3>
							<a href="{{$_post->getPermalink()}}">
								{{ $_post->title }}
							</a>
						</h3>
						<span>{{ Carbon::parse($_post->date)->format('d/m/Y') }}</span>
						<p>
							{!! Str::limit($_post->description, 200) !!}
						</p>
						<div class="read-more">
							<a href="{{ $_post->getPermalink() }}" class="read-more mb5">{!! trans('website.read_more') !!}</a>
						</div>
                    </article><!--/news -->
				</div>
            @endforeach
        </div> <!-- / newscontainer -->
		<div class="col-xs-12 col-md-3">
			@include('website.news.news_sidebar')
		</div>
    </div>
</main> <!-- /container -->
@endsection
