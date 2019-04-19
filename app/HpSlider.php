<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HpSlider extends Model
{
    protected $table = 'hpsliders';
    protected $fillable = ['title', 'description','slug','link','sort','is_active'];
    protected $fieldspec = [];

    public function setSlugAttribute($value)
    {
        $slug = ($value=='')? Str::slug($this->title) :Str::slug($value);
        if( $this->id!='') $count =self::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $this->id)->count();
        else $count =self::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $this->attributes['slug'] =$count ? "{$slug}-{$count}" : $slug;
    }

    function getFieldSpec ()
        // set the specifications for this database table
    {

        // build array of field specifications
        $this->fieldspec['id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 1,
            'required' => 1,
            'label'    => trans('admin.label.id'),
            'hidden'   => 1,
            'display'  => 0,
        ];
        $this->fieldspec['title']    = [
            'type'      => 'string',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => trans('admin.label.title'),
            'display'   => 1,
            'validation' =>'required'
        ];

        $this->fieldspec['description'] = [
            'type'      => 'string',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.description'),
            'lang'      => 0,
            'cssClass'  => 'wyswyg',
            'display'   => 1,
        ];
        $this->fieldspec['slug'] = [
            'type'      => 'string',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.slug'),
            'display'   => 1,
        ];
        $this->fieldspec['link'] = [
            'type'      => 'string',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.link'),
            'display'   => 1,
        ];
        $this->fieldspec['image'] = [
            'type'      => 'media',
            'pkey'      => 0,
            'required'  => 1,
            'hidden'    => 0,
            'label'     => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display'   => 1,
            'validation'=>'sometimes|required|mimes:jpeg,jpg,png,gif'

        ];
        $this->fieldspec['sort'] = [
            'type'      => 'integer',
            'required'  => 0,
            'label'     => trans('admin.label.position'),
            'hidden'    => 0,
            'display'   => 1,
            'cssInputSize'  => 'col-md-8 col-lg-4',
        ];
        $this->fieldspec['is_active'] = [
            'type'      => 'boolean',
            'pkey'      => 0,
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.publish'),
            'display'   => 1
        ];
        return $this->fieldspec;
    }

    public function scopeActive($query)    {
        $query->where('is_active', '=',1 );
    }

}
