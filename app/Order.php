<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use	App\maguttiCms\Tools\StoreHelper;

class Order extends Model
{
    protected $fillable = [
		'user_id',
		'cart_id',
		'products_cost',
		'shipping_cost',
		'vat_cost',
		'total_cost',
		'billing_address_id',
		'shipping_address_id',
		'token',
    ];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

	public function cart()
	{
		return $this->belongsTo('App\Cart');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function order_items()
	{
		return $this->hasMany('App\OrderItem');
	}

	public function payment()
	{
		return $this->hasOne('App\Payment');
	}

	public function billing_address()
	{
		return $this->belongsTo('App\Address', 'billing_address_id');
	}

	public function shipping_address()
	{
		return $this->belongsTo('App\Address', 'shipping_address_id');
	}

    function getFieldSpec()
    {
        return $this->fieldspec;
    }

	public function scopeList($query)
	{
		return $query->with(['order_items', 'payment', 'billing_address', 'shipping_address']);
	}

	public function getPermalink()
	{
		return url_locale('/order-review/'.$this->token);
	}

	public function getUserDisplayAttribute() {return $this->user->name;}
	public function getProductsDisplayAttribute()
	{
		$products = [];
		foreach ($this->order_items()->with('product')->get() as $_item) {
			$products[] = $_item->quantity.'x '.$_item->product->title;
		}
		return implode ('<br>', $products);
	}
	public function getPaymentMethodDisplayAttribute() {
		$payment = $this->payment;
		if ($payment)
			return $payment->payment_method->title;
		else
			return '';
	}
	public function getProductsCostDisplayAttribute() {return StoreHelper::formatPrice($this->products_cost);}
	public function getShippingCostDisplayAttribute() {return StoreHelper::formatPrice($this->shipping_cost);}
	public function getVatCostDisplayAttribute() {return StoreHelper::formatPrice($this->vat_cost);}
	public function getTotalCostDisplayAttribute() {return StoreHelper::formatPrice($this->total_cost);}

}
