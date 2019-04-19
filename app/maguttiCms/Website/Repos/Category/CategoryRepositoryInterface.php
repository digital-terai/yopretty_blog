<?php
/**
 * Created by PhpStorm.
 * User: Marco Asperti
 * Date: 03/07/2016
 * Time: 11:21
 */
namespace App\maguttiCms\Website\Repos\Category;

/**
 * Interface CategoryRepositoryInterface
 * @package App\maguttiCms\Website\Repos\Category
 */
interface CategoryRepositoryInterface
{
    public function getBySlug($slug);
    public function getPublished();
}
