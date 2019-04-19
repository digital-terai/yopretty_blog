<?php if( !isset( $_COOKIE['euCookie'] ) ) :  ?>
    <div class="cookie_notice hidden-print" role="status">
        <div>
            {!! trans('website.message.cookie')!!}<br>
            <span>
				<a href="https://www.iubenda.com/privacy-policy/{{ Setting::getOption('iubenda_code_'.LaravelLocalization::getCurrentLocale()) }}/cookie-policy" class="iubenda-nostyle no-brand iubenda-embed " title="{{ trans('website.cookie')}}">
					{!! trans('website.message.cookie_more_info')!!}
				</a>
			</span>
            - <span id="cookie_close" class="close_eu pointer" style="padding:0px;" href="javascript:void(0);">{!! trans('website.message.cookie_accept')!!}</span>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($){
            var cH = $.maCookieEu(this,{
                    position        : "bottom",
                    cookie_name     : "euCookie",
                    background      : "#1A171E",
                    delete          : true,
                }
            )
        })
    </script>
<?php endif; ?>
