<?php namespace App\maguttiCms\Domain\Article;

trait ArticlePresenter
{

    /*
    |--------------------------------------------------------------------------
    |  Seo & Meta
    |--------------------------------------------------------------------------
    */

    function getFullSlug($locale = '')
    {
        $locale = ($locale) ?: app()->getLocale();
        if ($this->parent && $this->parent->{'slug:it'} != 'home')
            return $this->parent->{'slug:' . $locale} . '/' . $this->{'slug:' . $locale};

        if ($this->{'slug:' . $locale} == 'home')
            return "";

        return $this->{'slug:' . $locale};
    }

    public function getPermalink($locale = '')
    {
        $url = ($this->sluggable['slug']['translatable']) ? $this->getFullSlug($locale) : $this->slug;
        return url_locale($url);
    }

    /**
     * GESTIONE OPZIONALE META
     * PER I SOCIALS
     */
    function metaTagGinius()
    {

        $description = "";
        $title = "";
        \SEO::opengraph()->addProperty('title', $title);
        \SEO::opengraph()->addProperty('description', $description);
        \SEO::twitter()->addValue('title', $title);
        \SEO::twitter()->addValue('description', $description);
    }
}
