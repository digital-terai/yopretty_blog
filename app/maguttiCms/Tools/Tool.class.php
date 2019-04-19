<?php namespace App\maguttiCms\Tools;
class Tool {

	//********************* PASSWORD AND TOKEN ********************************************/
	
	/**
	* Random password generator
	*
	* @param integer $length Desired length (optional)
	* @param string $flag Output type (NUMERIC, ALPHANUMERIC, NO_NUMERIC)
	* @return string Password
	*/
	public static function passwdGen($length = 8, $flag = 'ALPHANUMERIC')
	{
		switch ($flag)
		{
			case 'NUMERIC':
				$str = '0123456789';
				break;
			case 'NO_NUMERIC':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			default:
				$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
		}

		for ($i = 0, $passwd = ''; $i < $length; $i++)
			$passwd .= substr($str, mt_rand(0, Tools::strlen($str) - 1), 1);
		return $passwd;
	}
	public  static function encPwd($password){
	    	return $pwd = md5($password);
	}
	
	public static function generateToken() {
       return md5(uniqid(rand(), true));
    }
	
	/******************************** SEO E GESTIONE PAGINE URL ********************/
	/**
	* url della  pagina ma_curPageURL
	*
	* 
	* @return string $pageURL
	*/
	function ma_curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
    /**
	* return check   URL is  in the  current domain
	* @param  string $url   
	* @param  string $target (OPTIONAL - DEFAULT = new )
	* @return string
	*/
	function ma_url_target($url, $target='_new'){
	
		$curHost = parse_url(HTTP_SERVER);
		$linkHost= parse_url($url);
		if($curHost['host']== $linkHost['host']) return '';
		else return " target=\"".$target."\" ";
	
	}
	 /**
	* return check   URL is a  vaild  url
	* @param  string $str  
	* 
	* @return string  $str
	*/
	function ma_prep_url( $str = ''){
		if ($str == 'http://' OR $str == '')
		{
			return '';
		}
		
		if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
		{
			$str = 'http://'.$str;
		}
		
		return $str;
	}

	/********************************  LANG  HANDLER  ********************/
    /**
	* return init  the  website language
	* @param  string $defaultLang   
	* 
	* @return string $lang
	*/
	public static function comefrom( $defaultLang) {
		$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE']; 
		if (substr($lang, 0, 2) == 'en'){
			$lang='en';
		} 
		else if (substr($lang, 0, 2) == 'it'){
			$lang='it';
		}
		else $lang=$defaultLang;
	    return $lang;
	}
	
	 /**
	* return the bowser lang
	*  
	* 
	* @return string 
	*/
	function browserLang()
	{
		if (preg_match('/zh-tw/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			return "zh-TW";
		} else {
			return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
	}

}	