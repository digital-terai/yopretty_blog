<?php namespace App\maguttiCms\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Trait SluggableTrait for
 * adminPageController
 * @package App\maguttiCms\Sluggable
 */
trait SluggableTrait
{

    protected $value;
    protected $source_value;
    protected $slug_attribute;

    public static function bootSluggableTrait()
    {
        static::created(function($item){});
    }


    public function setSlugAttributes($slug_attribute){
        $this->slug_attribute = $slug_attribute;
        return $this;
    }


	public function sluggy(Model $model, $value,$source_value)
    {
        $count              = 0;
        $this->value        = $value;
        $this->source_value = $source_value;

        $slug  = ($this->canUpdateSlug($this->value)) ? ma_sluggy($this->source_value) : $this->value;

        if ($model->id != '') {
			if ($model::where('slug', $slug)->where('id', '!=', $model->id)->count()) {
				$count = $model::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $model->id)->count();
			}
		}
        else {
			if ($model::where('slug', $slug)->count()) {
				$count = $model::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
			}
		}
        return $count ? "{$slug}-{$count}" : $slug;
    }


    public function sluggyTranslatable(Model $model, $value,$locale='')
    {

        $count       = 0;
        $source      = (config('app.locale') == $locale) ? $this->getSlugSuorceField($model): $this->getSlugSuorceField($model).'_'.$locale;
        $this->value = $value;

        $this->source_value = $this->composeSlug($model,$this->request->get($source),$locale);
        $slug = ($this->canUpdateSlug($this->value)) ? ma_sluggy($this->source_value,'-',$locale) : $this->value;

        if( $slug=='' ) return "";

        if ($model->id != '' ) {
            if ($model::WhereTranslation('slug',$slug,$locale)->where('id', '!=', $model->id)->count()) {
                $count = $model::WhereTranslation('slug',$slug,$locale)->where('id', '!=', $model->id)->count();
            }
        }
        else {
            if ($model::WhereTranslation('slug', $slug,$locale)->count()) {
                $count = $model::WhereTranslation('slug',$slug,$locale)->count();
            }
        }
        return ($count) ? "{$slug}-{$count}" : $slug;
    }

    protected function attributeIsSluggable($attribute,$sluggableList){
        if(!is_array($sluggableList) )  return true;
        if(array_key_exists($attribute,$sluggableList)) return true;
        return false;
    }

    protected function slugIsTranslatable($slug_attribute){
        return (isset($slug_attribute['translatable']))?$slug_attribute['translatable']:false ;
    }

    protected function canUpdateSlug($slug_value=''){
        if($this->getSlugIsUpdatable()==true)  return true;
        return ($slug_value=='') ? true :false;
    }

    protected function getSlugIsUpdatable(){
         return (isset($this->slug_attribute['updatable']))? $this->slug_attribute['updatable'] : false;
    }

    protected function getSlugSuorceField(){
        return $this->slug_attribute['field'];
    }

    protected  function composeSlug($model, $string_to_slug,$locale){
        if(method_exists($model,'slugComposer')) return $model->slugComposer($string_to_slug,$locale);
        return $string_to_slug;
    }
}
