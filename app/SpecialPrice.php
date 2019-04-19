<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialPrice extends Model
{
    protected $fillable = [
		'product_code',
		'list_code',
		'price'
    ];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

	public function product()
	{
		return $this->belongsTo('App\Product', 'product_code', 'code');
	}

    function getFieldSpec()
    {
        return $this->fieldspec;
    }
}
