<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;


class Category extends Model
{
    use \Dimsav\Translatable\Translatable;
    use GFTranslatableHelperTrait;
    use \App\maguttiCms\Domain\Category\CategoryPresenter;

    protected $with = ['translations'];

    protected $fillable = ['title', 'description', 'abstract', 'slug', 'sort', 'pub', 'parent_id'];
    protected $fieldspec = [];

    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Trnslateble
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes = ['title', 'slug', 'description', 'seo_title', 'seo_description'];
    public $sluggable = ['slug' => ['field' => 'title', 'updatable' => false, 'translatable' => true]];

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */

    public function media()
    {
        return $this->morphMany('App\Media', 'model');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */

    function getFieldSpec()
    {
        $this->fieldspec['id'] = [
            'type' => 'integer',
            'minvalue' => 0,
            'pkey' => 'y',
            'required' => true,
            'label' => trans('admin.label.id'),
            'hidden' => 1,
            'display' => 0,
        ];
        $this->fieldspec['parent_id'] = [
            'type' => 'relation',
            'model' => 'category',
            'foreign_key' => 'id',
            'label_key' => 'title',
            'required' => 0,
            'label' => trans('admin.label.category'),
            'hidden' => 0,
            'display' => 0,
        ];

        $this->fieldspec['title'] = [
            'type' => 'string',
            'pkey' => 0,
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.title'),
            'display' => 1,
            'validation' =>'required'
        ];
        $this->fieldspec['slug'] = [
            'type' => 'string',
            'pkey' => 0,
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.slug'),
            'display' => 1,
        ];

        $this->fieldspec['description'] = [
            'type' => 'text',
            'size' => 600,
            'h' => 300,
            'required' => 0,
            'hidden' => 1,
            'label' => trans('admin.label.description'),
            'cssClass' => 'wyswyg',
            'display' => 0,
        ];

        $this->fieldspec['image'] = [
            'type' => 'media',
            'pkey' => 0,
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display' => 1,
            'validation'=>'sometimes|required|mimes:jpeg,jpg,png,gif'
        ];
        $this->fieldspec['banner'] = [
            'type' => 'media',
            'pkey' => 0,
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.banner'),
            'mediaType' => 'Img',
            'display' => 0,
            'validation'=>'sometimes|required|mimes:jpeg,jpg,png,gif'
        ];

        $this->fieldspec['sort'] = [
            'type' => 'integer',
            'required' => 0,
            'label' => trans('admin.label.position'),
            'hidden' => 0,
            'display' => 1,
        ];
        $this->fieldspec['pub'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.publish'),
            'display' => 1
        ];
        $this->fieldspec['seo_title'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.title'),
            'display' => 1,
        ];
        $this->fieldspec['seo_description'] = [
            'type' => 'text',
            'size' => 600,
            'h' => 300,
            'hidden' => 0,
            'label' => trans('admin.seo.description'),
            'cssClass' => 'no',
            'display' => 1,
        ];
        $this->fieldspec['seo_no_index'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.no-index'),
            'display' => 1
        ];
        return $this->fieldspec;
    }


    /*
    |--------------------------------------------------------------------------
    |  Scopes & Mutator
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {

        $query->where('pub', '=', 1)->orderBy('sort', 'ASC');
    }
}
