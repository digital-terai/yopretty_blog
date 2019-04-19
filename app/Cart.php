<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

class Cart extends Model
{
    protected $fillable = ['user_id', 'status'];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function cart_items()
	{
		return $this->hasMany('App\CartItem');
	}

	public function order()
	{
		return $this->hasOne('App\Order');
	}

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */
    function getFieldSpec()
    {
        return $this->fieldspec;
    }
}
