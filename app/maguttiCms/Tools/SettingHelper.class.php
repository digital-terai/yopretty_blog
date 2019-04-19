<?php namespace App\maguttiCms\Tools;

 use App\Setting;
/**
 * Class Setting
 * @package App\maguttiCms\Tools
 */
class SettingHelper {

	/**
	 * @param $key
	 * @return mixed
     */
	static public function getOption($key)
	{

		$settingObj = Setting::where('Key',$key)->first();
		if ($settingObj) {
			return $settingObj->value;
		}
		else {
			return '';
		}
	}

}
