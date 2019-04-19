<?php
namespace App\maguttiCms\Domain\Product;

use Mcamara\LaravelLocalization\LaravelLocalization;

trait ProductPresenter

{
    /*
    |--------------------------------------------------------------------------
    |  Seo & Meta
    |--------------------------------------------------------------------------
    */
    function getFullSlug($locale=''){
        /** @var  JSP  trick */
        $locale = ($locale)?:app()->getLocale();
		$trans_url = trans('routes.products', array(),$locale);
		$trans_url = str_replace('{category}', $this->category->{'slug:'.$locale}, $trans_url);
		$trans_url = str_replace('{product}', $this->{'slug:'.$locale}, $trans_url);
        return $trans_url;
    }

    public function getPermalink($locale='')
    {
        $url =  $this->getFullSlug($locale);
        return url_locale($url);
    }

    public function getInfoPermalink() {
        return url_locale('/contacts/?product_id='.$this->id);
    }
}
