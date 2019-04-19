@foreach ($categories as $_category)
	<div class="row">
		<div class="col-xs-12">
			<h3>{{$_category->title }}</h3>
			{!!$_category->description!!}
		</div>
	    @foreach ($_category->product()->active()->orderby('sort')->get() as $_item)
			<div class="col-xs-12 col-md-4 col-lg-3 mb25">
				<div class="row">
					<div class="col-xs-4 col-md-12 mb10">
						<a href="{{$_item->getPermalink()}}">
							<img src="{!! ImgHelper::get($_item->image, config('maguttiCms.image.thumbnail')) !!}" alt="{{ $_item->title }}" class="img-responsive">
						</a>
					</div>
					<div class="col-xs-8 col-md-12 mb10">
						<h5>
							<a href="{{$_item->getPermalink()}}">
								{{$_item->title }}
							</a>
						</h5>
						<p>
							{{ Stringable::truncate($_item->description, 100) }}
						</p>
					</div>
				</div>
			</div>
	   @endforeach
	</div>
@endforeach
