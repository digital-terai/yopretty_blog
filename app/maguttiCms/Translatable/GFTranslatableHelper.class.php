<?php namespace App\maguttiCms\Translatable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
|  Helper and override function for laravel-translatable
|--------------------------------------------------------------------------
|
|
*/

/**
 * Trait GFTranslatableHelperTrait
 * @package App\maguttiCms\Translatable
 */
trait GFTranslatableHelperTrait
{

    public function scopeTranslation(Builder $query, $key, $value, $locale = null)
    {
        return $query->whereHas('translations', function (Builder $query) use ($key, $value, $locale) {
            $query->where($this->getTranslationsTable() . '.' . $key, 'LIKE', $value);
            if ($locale) {
                $query->where($this->getTranslationsTable() . '.' . $this->getLocaleKey(), '=', $locale);
            }
        });
    }

    public function scopeTranslationOrderable(Builder $query, $sorta, $sortaType,$locale){
        return $query->join($this->getTranslationsTable().' as  t', 't.'.$this->getRelationKey(), '=', $this->getTable().'.id')
                     ->where('t.'.$this->getLocaleKey(), '=', $locale)
                     ->groupBy($this->getTable().'.id')
                     ->orderBy("t.".$sorta,$sortaType)
                     ->with('translations');
    }

	public function scopeTranslatedContent(Builder $query)	{
		return $query->whereHas('translations', function ($query) {
			$query->where('locale', app()->getLocale())->where('title', '!=', '');
		});
	}

    public static function getByTranslationSlug($slug,$locale=''){
        return self::WhereTranslation('slug',$slug,$locale)->first();
    }


    public function isAttributeTranslatable($key)
    {
        return (property_exists($this, 'translatedAttributes') && in_array($key, $this->translatedAttributes));
    }
}
