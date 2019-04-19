<?php
namespace App\maguttiCms\Website\Repos\Article;
/**
 * Created by PhpStorm.
 * User: Marco Asperti
 * Date: 03/07/2016
 * Time: 10:58
 */
use App\Article;
use App\maguttiCms\Website\Repos\DbRepository;
class DbArticleRepository extends DbRepository implements ArticleRepositoryInterface
{

    protected $model;
    function  __construct(Article $model)
    {
        $this->model = $model;
    }

    function getParentPage($parent)
    {

      $page = $this->getBySlug($parent,app()->getLocale());

      // Return false if page has parent because this method is used only for parent page
      if($page && $page->parent_id != 0) return false;

      return $page;

    }

    function getSubPage($parent, $child)
    {

      $parent = $this->getBySlug($parent,app()->getLocale());
      $child  = $this->getBySlug($child,app()->getLocale());

      // If $parent or $child doesn't exists
      if(!$parent || !$child) {
        return false;
      }

      // If $parent and $child doesn't match
      if($parent->id != $child->parent_id) {
        return false;
      }

      // Return $child data
      return $child;
    }
}
