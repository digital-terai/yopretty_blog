@extends('website.app')
@section('content')
<section id="map" class="map" ></section>
<main class="container">
	<div class="row">
		<div class="col-xs-12 col-md-6">
			@include('website.form.contact')
		</div>
		<div class="col-xs-12 col-md-6">
			<address>
				<h3>{!! config('maguttiCms.website.option.app.name')!!}</h3>
				<p>
					{!! config('maguttiCms.website.option.app.address')!!}<br>
					{!! config('maguttiCms.website.option.app.locality')!!}<br>
					{{HtmlHelper::createFAIcon('phone', 'fa-lg mr10')}}Tel {!! config('maguttiCms.website.option.app.phone')!!}<br>
					{{HtmlHelper::createFAIcon('fax', 'fa-lg mr10')}}Fax {!! config('maguttiCms.website.option.app.fax')!!}<br>
					{{HtmlHelper::createFAIcon('envelope', 'fa-lg mr10')}}<a href="mailto:{!! config('maguttiCms.website.option.app.email')!!}">{!! config('maguttiCms.website.option.app.email')!!}</a>
				</p>
			</address>
		</div>
	</div>
</main>
@endsection
@section('footerjs')
	@parent
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{Setting::getOption('GMAPS_KEY')}}"></script>
    <!-- JS Page Level -->
	<script type="text/javascript">
		var marker_config = [
			[
				'{!! config('maguttiCms.website.option.app.name')!!}',	//title
				{{config('maguttiCms.website.option.app.lat')}},	// lat
				{{config('maguttiCms.website.option.app.lng')}},	// lng
				'{{asset('website/images/map_marker.png')}}',	// icon image
				"<div class='mapPop'><b>{!! config('maguttiCms.website.option.app.name')!!}</b><br>{!! config('maguttiCms.website.option.app.address')!!}<br>{!! config('maguttiCms.website.option.app.locality')!!}<br></div>", //popup window content
			]
		];
		var gmap_config = {
			mapElement: 'map',
        	zoomLevel: 12,
			mapStyles: [],
        	marker_config: marker_config
		};
        jQuery(document).ready(function() {
            gMap.init();
        });
    </script>
@endsection
