<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
		'title',
		'code',
		'is_active'
    ];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

    function getFieldSpec()
    {
        $this->fieldspec['id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 1,
            'required' => 1,
            'label'    => 'id',
            'hidden'   => 1,
            'display'  => 0,
        ];
        $this->fieldspec['title'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => 'Title',
			'display'  => 1,
        ];
        $this->fieldspec['code'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => 'Code',
			'display'  => 1,
        ];
        $this->fieldspec['is_active'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => 'Boolean',
            'display'  => 1
        ];

        return $this->fieldspec;
    }

	public function scopeActive($query)
	{
		return $query->where('is_active', 1);
	}
}
