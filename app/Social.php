<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'socials';
    protected $fillable = ['title', 'description','link','icon','sort','is_active'];
    protected $fieldspec = [];


    function getFieldSpec ()
    {

        $this->fieldspec['id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 'y',
            'required' => 1,
            'label'    => 'id',
            'hidden'   => 1,
            'display'  => 0,
        ];
        $this->fieldspec['title']    = [
            'type'      => 'string',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => 'Social',
            'display'   => 1,
        ];
        $this->fieldspec['icon'] = [
            'type'     => 'string',
            'required' => true,
            'hidden'   => 0,
            'label'    => 'Font-Awesome class ',
            'display'  => 1,
        ];
        $this->fieldspec['link'] = [
            'type'      => 'string',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => 'Social link',
            'display'   => 1,

        ];
        $this->fieldspec['image'] = [
            'type'      => 'media',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => 'Image',
            'lang'      => 0,
            'mediaType' => 'Img',
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
        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'required' => 0,
            'label'    => 'Order',
            'hidden'   => 0,
            'display'  => 1,
        ];
        $this->fieldspec['is_active'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.publish'),
            'display'  => 1
        ];
      return $this->fieldspec;
    }
}
