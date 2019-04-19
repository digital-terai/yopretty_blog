<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $with = ['country'];

    protected $fillable = [
		'user_id',
		'street',
		'number',
		'zip_code',
		'city',
		'province',
		'country_id',
		'phone',
		'mobile',
		'email',
		'vat'
    ];
    protected $fieldspec = [];
    public $ajaxAccessibilityRoles = ['su'];
    public $sluggable = [];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

    function getFieldSpec()
    {
        return $this->fieldspec;
    }

	public function display($separator)
	{
		$display = '';
		$display .= $this->street;
		if ($this->number)
			$display .= ', '.$this->number;
		$display .= $separator;
		$display .= $this->zip_code.' '.$this->city.' ('.$this->province.')';
		$display .= $separator;
		$display .= $this->country->name;
		if ($this->phone) {
			$display .= $separator;
			$display .= 'Tel: '.$this->phone;
		}
		if ($this->mobile) {
			$display .= $separator;
			$display .= 'Cell: '.$this->mobile;
		}
		if ($this->email) {
			$display .= $separator;
			$display .= 'Email: '.$this->email;
		}

		return $display;
	}

	public function getDisplayInlineAttribute()
	{
		return $this->display(' - ');
	}

	public function getDisplayBlockAttribute()
	{
		return $this->display('<br>');
	}
}
