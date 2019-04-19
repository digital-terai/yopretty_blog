<?php
namespace App\maguttiCms\Admin;
Use Form;
Use App;
use Carbon\Carbon;

/**
 * Class AdminForm
 * @package App\maguttiCms\Admin
 */
class AdminList {

	/**
	 * @var
     */
	protected  $html;
	/**
	 * @var
     */
	protected  $property;
	/**
	 * @var
     */
	protected  $listLabel;

	/**
	 * @param $property
	 * @return $this
     */
	public  function  initList ($property)
	{
		$this->html ="";
		$this->property = $property;
		return $this;
    }

	/**
	 *
	 */
	 public function getListHeader(  )
 	{
 		$this->listLabel = explode(',', $this->property['fieldLabel']);
 		$html  = '';
 		$html .= $this->getSelectAbleHeader();
 		$nF    = 0; //  field number
 		foreach($this->property['field'] as $_code => $_item){
 			$html   .= "<th class=\"middle-vertical-align\">\n";
 				if (is_array($_item)) {
 					$html  .= trans('admin.label.'.$_code);
 				}
 				else {
 					$html  .= trans('admin.label.'.$_item);
 				}
 				$html  .= $this->getOrderableField($_code);
 			$html  .= "</th>\n";
 			$nF++;
 		}
 		echo $html;
 	}


	/**
	 * @return string
     */
	protected   function getSelectAbleHeader(){
		if ($this->property['selectable'])
			return "<th class=\"selectable-column\"></th>\n";
		else
			return '';
    }

	/**
	 * @param $i
	 * @return string
     */
	protected   function getOrderableField($i){
		$html = '';
		if (array_key_exists($i, $this->property['field'])) {
			$item = $this->property['field'][$i];
			if ($this->fieldIsOrderable($item)) {
				$curField = (is_array($item)) ? $item['field'] : $item;
				$html .= " <a href=\"?orderBy=$curField&orderType=desc\"><i class=\"fa fa-arrow-down\" aria-hidden=\"true\"></i></a>\n";
				$html .= " <a href=\"?orderBy=$curField&orderType=asc\"><i class=\"fa fa-arrow-up\" aria-hidden=\"true\"></i></a>\n";
			}
		}
		return $html;
	}

	/**
	 * @param $item
	 * @return bool
     */
	protected   function fieldIsOrderable($item ){
		return  (isset($item['orderable'])) ? $item['orderable'] : false;
	}
}
