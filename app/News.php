<?php namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;


use Illuminate\Support\Str;

use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class News extends Model
{

    use GFTranslatableHelperTrait;
    use \Dimsav\Translatable\Translatable;
    use \App\maguttiCms\Domain\News\NewsPresenter;

	protected $with = ['translations'];

	protected  $fillable  = ['title','description','date','sort','pub'];
	protected  $fieldspec = [];

	/*
    |--------------------------------------------------------------------------
    |  Sluggable & Translateble
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes    = ['title','slug','description','seo_title','seo_description'];
    public $sluggable               = ['slug'=>['field'=>'title','updatable'=>false]];

    /*
    |--------------------------------------------------------------------------
    |  RELATIONS
    |--------------------------------------------------------------------------
    */
    public function media()
    {
        return $this->morphMany('App\Media', 'model')->orderBy('sort');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function saveTags($values)
    {
        if(!empty($values))
        {
            $this->tags()->sync($values);
        } else {
            $this->tags()->detach();
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  DATE ATTRIBUTE
    |--------------------------------------------------------------------------
    */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value);

    }

    public function getDateAttribute($value)
    {
        //return Carbon::parse($value)->format('d-m-Y');
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getFormattedDate()
    {
        //return Carbon::parse($this->attributes['date'])->formatLocalized('%d %B %Y');
        return Carbon::parse($this->attributes['date'])->format('d-m-Y');
    }



    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */
	function getFieldSpec ()
    {

        $this->fieldspec['id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 1,
            'label'    => 'id',
            'hidden'   => 1,
            'display'  => 0,
        ];
		$this->fieldspec['date'] = [
			'type'            => 'string',
			'required'        => 1,
			'hidden'          => 0,
			'label'           => 'Publish date',
			'display'         => 1,
			'cssClass'        => 'datetimepicker',
            //'cssClass'      => 'datepicker',
			'cssClassElement' => 'col-sm-3',
		];
        $this->fieldspec['start_date'] = [
            'type'            => 'date',
            'required'        => 1,
            'hidden'          => 0,
            'label'           => 'Data Ora evento',
            'display'         => 1,
            'cssClass'        => 'datetimepicker',
            'cssClassElement' => 'col-sm-2',
        ];
		$this->fieldspec['title'] = [
			'type'      =>'string',
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'Title',
			'display'   => 1,
		];
		$this->fieldspec['slug'] = [
			'type'      => 'string',
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'Slug',
			'display'   => 1,
		];
		$this->fieldspec['description'] = [
			'type'      => 'text',
			'size'      => 600,
			'h'         => 300,
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'Description',
			'cssClass'  => 'wyswyg',
			'display'   => 1,
		];
		$this->fieldspec['tag'] = [
            'type'       	=> 'relation',
            'model'      	=> 'Tag',
            'relation_name' => 'tags',
            'foreign_key'   => 'id',
			'label_key'     => 'title',
			'label'         => 'Tags',
            'required'      => 0,
			'display'       => 1,
            'hidden'        => 0,
			'multiple'      => 1
		];
		$this->fieldspec['link'] = [
			'type'      => 'string',
			'size'      => 600,
			'required'  => 0,
			'hidden'    => 0,
			'label'     => 'External url',
			'display'=>0,
		];
		$this->fieldspec['image'] = [
			'type'      =>'media',
			'required'  => 0,
			'hidden'    => 0,
			'label'     => 'Image',
			'extraMsgEnabled'=>'Code',
			'mediaType' => 'Img',
			'display'   => 1,
		];
		$this->fieldspec['doc'] = [
			'type'      =>'media',
			'required'  =>'n',
			'hidden'    => 0,
			'label'     =>'Document',
			'lang'      => 0,
			'mediaType' => 'Doc',
			'display'   => 0,
		];
        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'required' => 0,
            'label'    => 'Order',
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
        $this->fieldspec['seo_title'] = [
            'type'     => 'string',
            'required' => 'n',
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
            'display'  => 0
        ];
	    return $this->fieldspec;
	}


   /*
   |--------------------------------------------------------------------------
   |  Scopes & Mutator
   |--------------------------------------------------------------------------
   */

    public function scopeLatestPublished($query,$limit = 5)
    {
        return $query->published()->translatedContent()->latest()->limit($limit);
    }

    public function scopePublished($query)
    {
        return $query->where('pub', 1)->where('date', '<=', Carbon::now());
    }

    public function scopeByDate($query)
    {
        return $query->orderBy('date', 'desc');
    }
}
