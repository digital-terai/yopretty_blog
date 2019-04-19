<?php namespace App\maguttiCms\Admin;
use Form;
use App;

/**
 * Class AdminFormImageRelation
 * @package App\maguttiCms\Admin
 */
class AdminFormImageRelation  {

    protected  $property;
    protected  $a;
    protected  $field;
    protected  $image_field = "image";
    protected  $seletedItem;
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    public function getThumbRelation($obj, $field, $selItem = '', $selectedArray = '') {

        $this->field = $field;
        $this->seletedItem = $selItem;
        $this->a     = ( isset( $this->property['foreign_key'] ) ) ? $this->property['foreign_key'] : 'id';
        $this->image_field = ( isset( $this->property['image_field']  )  ) ? $this->property['image_field'] : $this->image_field;

        $html ="<div class=\"row row-semi-condensed\">";
        $html   .= "<input type=\"hidden\" value='". $this->seletedItem ."' name=\"". $this->field ."\" id=\"". $this->field ."\">";
        $html   .= $this->getSelectedImage($obj);
        $html   .= $this->getImageList($obj);
        $html .= "</div>";

        return    $html ;
    }


    protected function getSelectedImage($obj){
        $html = "";
        foreach( $obj as $item ) {
            if ($item->{$this->a} ==  $this->seletedItem ) $html .= $this->getHtmlImage($item,"active");
        }
        return $html;
    }

    protected function getImageList($obj){
        $html = "";
        foreach( $obj as $item ) {
            if ($item->{$this->a} !=    $this->seletedItem ) $html .= $this->getHtmlImage($item);
        }
        return $html;
    }

    protected function getHtmlImage($item,$class="inactive"){

        $relationModel   =  "App\\".$this->property['model'] ;
        $objMedia        = $relationModel::find($item->{$this->a});

        $html ="<div class=\"col-xs-4 col-md-2\"><a href=\"#\" 
                     data-image-relation=\"".$this->field."\"  data-image-id =\"".$item->{$this->a}."\" class=\"thumbnail ".$class."\">";
            $html .="<img src=\"".ma_get_image_from_repository($objMedia->image)."\" alt=\"".$item->title."\" class='img-responsive '>";
        $html .="</a></div>";
        return $html;
    }
}
