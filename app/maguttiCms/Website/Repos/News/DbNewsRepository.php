<?php
namespace App\maguttiCms\Website\Repos\News;

/**
 * Created by PhpStorm.
 * User: Marco Asperti
 * Date: 03/07/2016
 * Time: 10:58
 */
use App\maguttiCms\Website\Repos\News\NewsRepositoryInterface;
use App\News;
use App\maguttiCms\Website\Repos\DbRepository;
use Carbon\Carbon;

/**
 * Class DbPostRepository
 * @package App\maguttiCms\Website\Repos\Post
 */
class DbNewsRepository extends DbRepository implements NewsRepositoryInterface
{

    /**
     * @var News
     */
    protected $model;

    /**
     * DbNewsRepository constructor.
     * @param News $model
     */
    function  __construct(News $model)
    {
        $this->model = $model;
    }

	function  getLatest($limit){
		if ($limit == 1)
			return $this->model->latest($limit)->first();
		else
			return $this->model->latest($limit)->get();
	}

	/**
	* @return mixed
	*/
	function  getPublished()
	{
		return $this->published()->where('date','<=',Carbon::now())->orderBy('date', 'desc')->get();
	}
}
