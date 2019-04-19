<div id="social-newsletter" class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-6 mb10">
			@include('website.partials.widgets_newsletter')
		</div>
		<div class="col-xs-12 col-sm-6 mb10">
			@include('website.partials.social')
		</div>
	</div>
</div>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-8">
				<h6>{!! config('maguttiCms.website.option.app.name')!!}</h6>
				<p>
					© <?php echo date('Y'); ?> {!! config('maguttiCms.website.option.app.legal')!!}<br>
					{!! config('maguttiCms.website.option.app.name')!!} - {!! config('maguttiCms.website.option.app.locality')!!} - P.IVA {!! config('maguttiCms.website.option.app.vat')!!}<br>
					Tel: {!! config('maguttiCms.website.option.app.phone')!!} - Fax: {!! config('maguttiCms.website.option.app.fax') !!} - <a href="mailto:{!! config('maguttiCms.website.option.app.email') !!}">{!! config('maguttiCms.website.option.app.email') !!}</a><br>
				</p>
			</div>
			<div class="col-xs-12 col-md-4 text-right">
				<p>
					<a href="https://www.iubenda.com/privacy-policy/{{ data_get($site_settings,'iubenda_code_'.LaravelLocalization::getCurrentLocale()) }}" class="iubenda-nostyle no-brand iubenda-embed " title="{{ trans('website.privacy')}}">
						{{ trans('website.privacy')}}
					</a> |
					<a href="https://www.iubenda.com/privacy-policy/{{ data_get($site_settings,'iubenda_code_'.LaravelLocalization::getCurrentLocale()) }}/cookie-policy" class="iubenda-nostyle no-brand iubenda-embed " title="{{ trans('website.cookie')}}">
						{{ trans('website.cookie')}}
					</a> |
					<a href="{{ data_get($site_settings,'credits_url') }}" target="_blank">Credits</a>
				</p>
			</div>
		</div>
	</div>
</footer>
