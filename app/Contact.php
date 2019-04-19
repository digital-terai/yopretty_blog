<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = ['request_product_id','name','surname','subject','company','email', 'message', 'status', 'created_by'];
    protected $fieldspec = [];

	public function product() {
        return $this->belongsTo('App\Product','request_product_id','id');
    }

    function getFieldSpec ()
    // set the specifications for this database table
    {
        $this->fieldspec['id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'required' => 1,
            'label'    => trans('admin.label.id'),
            'hidden'   => 1,
            'display'  => 0,
        ];
        // build array of field specifications
        $this->fieldspec['created_at'] = [
            'type'      => 'date-readonly',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.created_at'),
            'display'   => 1
        ];
        $this->fieldspec['request_product_id'] = [
            'type'      => 'integer',
            'size'      => 5,
            'required'  => 1,
            'hidden'    => 1,
            'display'   => 0,
        ];
        $this->fieldspec['email'] = [
            'type'     => 'readonly',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.email'),
            'display'  => 1,
        ];
        $this->fieldspec['name'] = [
            'type'     => 'readonly',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.name'),
            'display'  => 1,
        ];
        $this->fieldspec['company'] = [
            'type'      => 'readonly',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => trans('admin.label.company'),
            'display'   => 1,
        ];
        $this->fieldspec['subject'] = [
            'type'      => 'readonly',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => trans('admin.label.subject'),
            'display'   => 1,
        ];
        $this->fieldspec['message'] = [
            'type'      => 'readonly',
            'size'      => 600,
            'h'         => 300,
            'required'  => 1,
            'hidden'    => 1,
            'label'     => trans('admin.label.message'),
            'display'   => 0,
        ];
        $this->fieldspec['status'] = [
            'type'      => 'boolean',
            'pkey'      => 0,
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.read'),
            'display'   => 1
        ];
        return $this->fieldspec;
    }
}
