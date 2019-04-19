<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
	use SoftDeletes;

    protected $fillable = [
		'order_id',
		'payment_method_id',
		'code',
		'transaction',
		'notes',
    ];
	protected $dates = ['deleted_at'];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

	public function order()
	{
		return $this->belongsTo('App\Order');
	}

	public function payment_method()
	{
		return $this->belongsTo('App\PaymentMethod');
	}

    function getFieldSpec()
    {
        return $this->fieldspec;
    }
}
