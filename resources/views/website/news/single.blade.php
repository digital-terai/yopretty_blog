@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <div class="row">
        <div class="col-sx-12 col-md-9">
			<h1>{{ $news->title }}</h1>
            <div class="row">
				<div class="col-xs-12 mb10">
					<img src="{!! ImgHelper::get_cached($news->image, config('maguttiCms.image.medium')) !!}" alt="{{ $news->title }}" border="0" class="img-responsive">
				</div>
				<div class="col-xs-12 mb10">
					<p><i class="fa fa-calendar mr10"></i>{{ $news->date }}</p>
					{!! $news->description !!}
					@include('website.news.news_share')
				</div>
            </div>
        </div> <!-- / newscontainer -->
		<div class="col-xs-12 col-md-3">
			@include('website.news.news_sidebar')
		</div>
    </div>
</main> <!-- /container -->
@endsection
