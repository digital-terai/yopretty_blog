<?php
namespace App\maguttiCms\Domain\News;
use App\maguttiCms\Tools\Stringable;

trait NewsPresenter

{
    /*
    |--------------------------------------------------------------------------
    |  Seo & Meta
    |--------------------------------------------------------------------------
    */
    function getFullSlug($locale=''){
        $locale = ($locale)?:app()->getLocale();
        return  'news/'.$this->{'slug:'.$locale};
    }


    public function getPermalink($locale='')
    {
        $url =  $this->getFullSlug($locale);
        return url_locale($url);
    }

	public function getExcerpt($length = 200) {
		return Stringable::truncate($this->description, $length);
	}
}
