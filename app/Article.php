<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\maguttiCms\Builders\ArticleBuilder;
use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

/**
 * Class Article
 * @package App
 */
class Article extends Model
{
    use  GFTranslatableHelperTrait;
    use \Dimsav\Translatable\Translatable;

    use \App\maguttiCms\Domain\Article\ArticlePresenter;

	protected $with = ['translations'];

    protected $fillable = ['title', 'subtitle',  'abstract', 'description',
                           'slug', 'sort', 'pub','top_menu', 'parent_id',
                           'link', 'template_id','ignore_slug_translation',
                           'doc'];
    protected $fieldspec = [];

    public $ajaxAccessibilityRoles = ['su'];

    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Trnslateble
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes = ['menu_title', 'title','slug',
                                    'subtitle', 'abstract', 'description',
                                    'seo_title', 'seo_description', 'seo_no_index'];

    public $sluggable            =  ['slug'=>['field'=>'title','updatable'=>false,'translatable'=>true]];


    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */
    public function template()
    {
        return $this->belongsTo('App\Domain', 'template_id', 'id');
    }

    public function media()
    {
        return $this->morphMany('App\Media', 'model');
    }

    public function parent()
    {
        return $this->hasOne('App\Article','id','parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Article', 'parent_id', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query)
    {
        return new ArticleBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */
    function getFieldSpec()
    {
        $this->fieldspec['id'] = [
            'type'      => 'integer',
            'minvalue'  => 0,
            'pkey'      => 1,
            'required'  => 1,
            'label'     => trans('admin.label.id'),
            'hidden'    => 1,
            'display'   => 0,
        ];
        $this->fieldspec['parent_id'] = [
            'type'        => 'relation_tree',
            'tree_field'  => 'parent_id',
            'order_field' => 'sort',
            'model'       => 'article',
            'foreign_key' => 'id',
            'label_key'   => 'title',
            'required'    => 0,
            'label'       => trans('admin.label.parent'),
            'hidden'      => 0,
            'display'     => 1,
        ];
        $this->fieldspec['template_id'] = [
            'type'        => 'relation',
            'model'       => 'Domain',
            'filter'      => ['domain' => 'template'],
            'foreign_key' => 'id',
            'label_key'   => 'title',
            'required'    => 0,
            'label'       => trans('admin.label.template'),
            'hidden'      => 0,
            'display'     => 1,
        ];
        $this->fieldspec['menu_title'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.menu_title'),
            'display'  => 1,
        ];
        $this->fieldspec['title'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.title'),
            'display'  => 1,
            'validation' =>'required'
        ];
        $this->fieldspec['subtitle'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.subtitle'),
            'display'  => 1,
        ];
        $this->fieldspec['slug'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.slug'),
            'display'  => 1,
        ];
        $this->fieldspec['description'] = [
            'type'     => 'text',
            'size'     => 600,
            'h'        => 300,
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.description'),
            'cssClass' => 'wyswyg',
            'display'  => 1,
        ];
        $this->fieldspec['abstract'] = [
            'type'     => 'text',
            'size'     => 600,
            'h'        => 100,
            'required' => 'n',
            'hidden'   => 0,
            'label'    => trans('admin.label.additional'),
            'cssClass' => 'wyswyg',
            'display'  => 1,
        ];
        $this->fieldspec['link'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.ext_url'),
            'display'  => 1,
        ];
        $this->fieldspec['image'] = [
            'type'      => 'media',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display'   => 1,
			'disk'      => 'media',
        ];
        $this->fieldspec['doc'] = [
            'type'        => 'media',
            'required'    => 0,
            'hidden'      => 0,
            'label'       => trans('admin.label.doc'),
            'lang'        => 0,
            'mediaType'   => 'Doc',
            'display'     => 1,
			'uploadifive' => 1,
        ];
        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'required' => 0,
            'label'    => trans('admin.label.position'),
            'hidden'   => 0,
            'display'  => 1,
        ];
        $this->fieldspec['pub'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.publish'),
            'display'  => 1
        ];
        $this->fieldspec['top_menu'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.top_menu'),
            'display'  => 1
        ];
        $this->fieldspec['ignore_slug_translation'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.slug_ignore'),
            'display'  => 1
        ];
        $this->fieldspec['seo_title'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.seo.title'),
            'display'  => 1,
        ];
        $this->fieldspec['seo_description'] = [
            'type'     => 'text',
            'size'     => 600,
            'h'        => 300,
            'hidden'   => 0,
            'label'    => trans('admin.seo.description'),
            'cssClass' => 'no',
            'display'  => 1,
        ];
        $this->fieldspec['seo_no_index'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.seo.no-index'),
            'display'  => 1
        ];
        return $this->fieldspec;
    }
}
