<?php namespace App\maguttiCms\Admin;
use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class AdminTree  {

    protected  $tree_collection;
    protected  $level;
    protected  $property;

    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    public function getTreeRelation($obj,$parent=0,$level=0) {

        if($obj->where($this->property['tree_field'], $parent)) {
            $level++;
            if(data_get($this->property,'order_field')) $obj->sortBy($this->property['order_field']);
            foreach ($obj->where($this->property['tree_field'], $parent) as $item) {
                $item->title = $this->createSeparator($level).$item->title;
                $this->tree_collection[] = $item;
                $this->getTreeRelation($obj, $item->id,$level);
            };
        }
        return $this->tree_collection;
    }


    function  createSeparator($level){
        return ($level>1) ? "|".str_repeat("__",$level):'';
    }
}
