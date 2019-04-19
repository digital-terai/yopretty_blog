<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var array
     */
    protected $fillable  = ['value','key','domain','description'];
    /**
     * @var array
     */
    protected $fieldspec = [];

    /**
     * @return array
     */
    public function getFieldSpec ()
    {

        $this->fieldspec['id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 'y',
            'required' =>true,
            'label'    => 'id',
            'hidden'   => 1,
            'display'  => 0,
        ];
        $this->fieldspec['domain'] = [
            'type'      => 'string',
            'required'  => false,
            'hidden'    => 0,
            'label'     => 'Domain',
            'display'   => 1,
        ];
        $this->fieldspec['key'] = [
            'type'      => 'string',
            'required'  => true,
            'hidden'    => 0,
            'label'     => 'Key',
            'display'   => 1,
        ];
        $this->fieldspec['value'] = [
            'type'      => 'string',
            'required'  => true,
            'hidden'    => 0,
            'label'     => 'Value',
            'display'   => 1,
        ];
        $this->fieldspec['description'] = [
            'type'      => 'text',
            'size'      => 600,
            'h'         => 300,
            'required'  => false,
            'hidden'    => 0,
            'label'     => 'Description',
            'cssClass'  => '',
            'display'   => 1,
        ];
        return $this->fieldspec;
    }
}