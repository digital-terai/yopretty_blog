<!--=== news side bar ===-->
@inject('posts','App\News')
<h3>Latest news</h3>
<div class="row">
	@foreach ( $posts->LatestPublished(100)->get() as $_post )
		<div class="col-xs-12 col-sm-6 col-md-12">
			<div class="row">
				<div class="col-xs-4 mb10">
					<a href="{{ $_post->getPermalink() }}">
						<img class="img-responsive"  src="{!! ImgHelper::get($_post->image,config('maguttiCms.image.small')) !!}">
					</a>
				</div>
				<div class="col-xs-8 mb10">
					<h4>
						<a href="{{$_post->getPermalink()}}">{{ $_post->title }}</a>
					</h4>
					<p>{{ $_post->getFormattedDate() }}</p>
				</div>
			</div>
		</div>
	@endforeach
</div>
