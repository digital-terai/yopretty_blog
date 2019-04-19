<?php namespace App\maguttiCms\Tools;

use App\Setting;

/**
* Class Setting
* @package App\maguttiCms\Tools
*/
class HtmlHelper {
	protected $args = [];

	public function setHtmlTagAttributes($array) {
		foreach($array as $key => $value) {
			$this->args[$key] = $value;
		}
		return $this;
	}

	public function getHtmlTagAttributes() {
		return $this->args;
	}

	public function createHtmlTagAttributes() {
		$attribute_string = "";

		foreach($this->getHtmlTagAttributes() as $key => $value) {
			$attribute_string .= $key ."=\"" . $value . "\" ";
		}

		return $attribute_string;
	}

	/**
	* @param $icons
	* @param $classes
	* @param $forceicon
	* @param $echo
	* @return mixed
	*/
	public static function createFAIcon($icons, $classes = '', $force_set = '', $echo = true) {
		$arr_icons = explode(',', $icons);
		$str_classes = implode(' ',explode(',', $classes));

		$set = ($force_set)? $force_set: config('maguttiCms.website.option.icons');

		switch ($set) {
			case 'fa':
				if ((count($arr_icons) == 1) || ($forceicon !== false)) {
					//simple icon
					$output = '<i class="fas fa-'.$arr_icons[0].' '.$str_classes.'"></i>';
				}
				else {
					//stacked icon
					$output = '';
					$output .= '<span class="fa-stack '.$str_classes.'">';
					$output .= '<i class="fas fa-'.$arr_icons[0].' fa-stack-2x"></i>';
					$output .= '<i class="fas fa-'.$arr_icons[1].' fa-stack-1x fa-inverse"></i>';
					$output .= '</span>';
				}
				break;
			case 'mi':
				$output = '<i class="material-icons '.$str_classes.'">'.$arr_icons[0].'</i>';
				break;
		}

		if ($echo) echo $output; else return $output;
	}

	public static function checkError($errors, $field) {
		if ($errors->has($field)) {
			return 'input-danger';
		}
	}

    /**
     *  Youtube  video embed
     * @param $id
     * @param string $ratio
     * @param string $extra_class
     * @return string
     */
	public static function videoEmbed($id, $ratio = '16by9',$extra_class="") {
		$output = '';
		$output .= '<div class="embed-responsive embed-responsive-'.$ratio.' '.$extra_class.'">';
        $output .= '<iframe class="embed-responsive-item" src="'.self::getYoutubeUrl($id).'" allowfullscreen></iframe>';
		$output .= '</div>';
		return $output;
	}

	// Get responsive image
	public function get_responsive($src, $args_small=['w' => 768], $args_medium=['w' => 1200]) {
		return "<picture>
		<source media='(max-width: 768px)' sizes='100vw'
		srcset='". \ImgHelper::get_cached($src, $args_small) ."'>
		<source media='(max-width: 1200px)' sizes='100vw'
		srcset='". \ImgHelper::get_cached($src, $args_medium) ."'>
		<img src='".ma_get_image_from_repository($src)."' ".$this->createHtmlTagAttributes().">
		</picture>";
	}

    /**
     * GF_ma
     * @param $text
     * @param $index
     * @return string
     */
    public  function content_part($text,$index=1) {
        $array = explode('<!-- pagebreak -->',$text);
        $index = (int)$index-1;
	    return (isset($array[$index])) ? $array[$index]:'';
    }

    /**
     * GF_ma
     * @param $text
     * @return array
     */
    public  function content_part_looper($text) {
        return explode('<!-- pagebreak -->',$text);
    }

	public static function getYoutubeUrl($id)
	{
		return 'https://www.youtube-nocookie.com/embed/'.$id.'?rel=0';
	}
}
