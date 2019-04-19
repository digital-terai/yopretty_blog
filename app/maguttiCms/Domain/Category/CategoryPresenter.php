<?php
namespace App\maguttiCms\Domain\Category;

trait CategoryPresenter

{
    /*
    |--------------------------------------------------------------------------
    |  Seo & Meta
    |--------------------------------------------------------------------------
    */
    function getFullSlug($locale=''){
		/** @var  JSP  trick */
        $locale = ($locale)?:app()->getLocale();
        return  str_replace('{category?}',$this->{'slug:'.$locale},trans('routes.category',array(),$locale));
    }

    public function getPermalink($locale='')
    {
        $url =  $this->getFullSlug($locale);
        return url_locale($url);
    }
}
