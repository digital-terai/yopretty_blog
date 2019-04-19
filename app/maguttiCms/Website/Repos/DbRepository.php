<?php
/**
 * Created by PhpStorm.
 * User: Marco Asperti
 * Date: 03/07/2016
 * Time: 11:40
 */
namespace App\maguttiCms\Website\Repos;
use Carbon\Carbon;

/**
 * Class DbRepository
 * @package App\maguttiCms\Website\Repos
 */
abstract class DbRepository
{

    /**
     * @var News
     */
    protected $model;

    /**
     * DbRepository constructor.
     * @param $model
     */
    function  __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug,$locale=''){
        if(isset($this->model->translatedAttributes) && $this->model->isAttributeTranslatable('slug'))  return  $this->model->getByTranslationSlug($slug,$locale);
        return $this->model->where('slug','=',$slug)->first();
    }

    /**
     * @return mixed
     */
    public function published()    {
        return $this->model->where('pub', '=',1);
    }
}
