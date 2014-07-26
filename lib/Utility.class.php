<?php
class Utility{
	public static $numberMap = array(
		0 => '零',1 => '一',2=>'二',3=>'三',4=>'四',5=> '五',6=>'六',7=>'七' ,8=> '八',9=>'九',
	);
	
	const RETURN_URL_KEY = "Utility_Return_Url";
	
	

	
	
	public static function getUserIP($defaultIP = null){ //获取用户IP todo
		
		if(isset($_SERVER['HTTP_CLIENTIP'])){
			$userIP = $_SERVER['HTTP_CLIENTIP'];
		} else if(isset($_SERVER['REMOTE_ADDR'])){
			$userIP = $_SERVER['REMOTE_ADDR'];
		} else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$intPos = strrpos($userIP, ',');
			if($intPos > 0){
				$userIP = substr($userIP, $intPos+1);
			}
		} else if(isset($_SERVER['HTTP_CLIENT_IP'])){
			$userIP = $_SERVER['HTTP_CLIENT_IP'];
		}
		$userIP = strip_tags($userIP);
		$userIP = trim($userIP);
		
		if(!$userIP && $defaultIP){
			$userIP = $defaultIP;
		}
		
		return $userIP;
	}
	
	/**
	 * 页面跳转函数
	 *
	 * 这里使用修改头文件的方式现实页面跳转
	 * 这里要注意的是调用这个函数之前 页面不能有任何输出 否则跳转失败
	 * 跳转后会退出程序
	 *
	 * @param string $u 跳转页面
	 */
	public static function Redirect($u=null) {
		if (!$u) $u = self::GetReturnUrl();
		if (!$u) $u = $_SERVER['HTTP_REFERER'];
		if (!$u) $u = '/';
		Header("Location: {$u}");
		exit;
	}
	
	public static function SetReturnUrl($url = ''){
		$url = $url ? $url : self::GetCurrentUri();
		Session::Set(self::RETURN_URL_KEY, $url);
	}
	
	public static function GetReturnUrl(){
		return Session::Get(self::RETURN_URL_KEY, true);
	}
	
	public static function GetCurrentUri(){
		$uri = $_SERVER['REQUEST_URI'];
		return $uri;
	}
	
	/**
	 * 阿拉伯数字转化成中文数字
	 */
	public static function TransNumberToCN($number){
		$number = strval($number);
		
		$temp = '';
		for($i = 0 ; $i< strlen($number); $i ++){
			$curNumStr = self::$numberMap[$number[$i]];
			if($curNumStr){
				$temp .= $curNumStr;
			}
		}
		
		return $temp;
	}
}