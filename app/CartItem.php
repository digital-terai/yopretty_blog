<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
		'cart_id',
		'product_code',
		'product_model_code',
		'quantity'
    ];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

	public function product()
	{
		return $this->belongsTo('App\Product', 'product_code', 'code');
	}

	public function product_model()
	{
		return $this->belongsTo('App\ProductModel', 'product_model_code', 'code');
	}

	public function cart()
	{
		return $this->belongsTo('App\Cart');
	}

	public function order_item()
	{
		return $this->hasOne('App\OrderItem');
	}

    function getFieldSpec()
    {
        return $this->fieldspec;
    }

	public function scopeList($query)
	{
		return $query->with('product')->orderBy('created_at');
	}
}
