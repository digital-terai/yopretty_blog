<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App
 */
class Error extends Model
{
    protected $fillable = ['message', 'file', 'line', 'trace'];
    protected $fieldspec = [];

    public $ajaxAccessibilityRoles = ['su'];

    public $sluggable            =  [];

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */
    function getFieldSpec() {
        return $this->fieldspec;
    }
}
