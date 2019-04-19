<?php

use App\maguttiCms\Tools\HtmlHelper;
use App\maguttiCms\Tools\StoreHelper;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// localization
function  get_locale() {
	return LaravelLocalization::getCurrentLocale();
}
function  url_locale($url) {
	return LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), URL::to($url));
}

function get_image($file)
{
	return ma_get_image_from_repository($file);
}
function get_doc($file)
{
	return ma_get_doc_from_repository($file);
}

// icons
function icon($icons, $classes = '', $force_set = '', $echo = true) {
	return Htmlhelper::createFAIcon($icons, $classes, $force_set, $echo);
}

// store
function store_currency() {
	return config('maguttiCms.store.currency_symbol');
}
function store_enabled() {
	return StoreHelper::isStoreEnabled();
}
