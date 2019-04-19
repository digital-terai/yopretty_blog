<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

class Domain extends Model
{
    use \Dimsav\Translatable\Translatable;
    use GFTranslatableHelperTrait;

    public    $translatedAttributes = ['title'];
    protected $fillable  = ['domain','title','value','pub','sort'];
    protected $fieldspec = [];


    function getFieldSpec ()
    {

        $this->fieldspec['id'] = [
            'type'      => 'integer',
            'minvalue'  => 0,
            'pkey'      => 1,
            'required'  => true,
            'label'     => trans('admin.label.id'),
            'hidden'    => 1,
            'display'   => 0,
        ];

        $this->fieldspec['domain'] = [
            'type'      => 'string',
            'required'  => true,
            'hidden'    => 0,
            'label'     => trans('admin.label.domain'),
            'display'   => 1,
        ];

        $this->fieldspec['title'] = [
            'type'      => 'string',
            'required'  => true,
            'hidden'    => 0,
            'label'     => trans('admin.label.title'),
            'display'   => 1,
        ];

        $this->fieldspec['value'] = [
            'type'      => 'string',
            'required'  => true,
            'hidden'    => 0,
            'label'     => trans('admin.label.value'),
            'display'   => 1,
        ];

        $this->fieldspec['sort'] = [
            'type'      => 'integer',
            'required'  => 0,
            'label'     => trans('admin.label.position'),
            'hidden'    => 0,
            'display'   => 1,
        ];

        $this->fieldspec['pub'] = [
            'type'      => 'boolean',
            'pkey'      => 0,
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.publish'),
            'display'   => 1
        ];
        return $this->fieldspec;
    }

    /*****************************  REPOSITORY **********************/
    public function scopePublished($query)    {

        $query->where('pub', '=',1 );
    }

    public function scopeByDomain($query,$domain)    {

        $query->where('domain', '=',$domain )->published();
    }

}
