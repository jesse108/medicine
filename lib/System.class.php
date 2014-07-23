<?php
class System{
	const MESSAGE_INDEX = 1;
	const MESSAGE_ADMIN = 2;
	public static $messageKey = "System_message";
	
	public static function SetError($message,$type = self::MESSAGE_INDEX){
		$key = self::$messageKey . "_error_{$type}";
		Session::Set($key, $message);
	}
	
	public static function AddError($message,$type = self::MESSAGE_INDEX){
		$error = strval(self::GetError($type,false));
		$error = "{$error},{$message}";
		self::SetError($error,$type);
	}
	
	public static function GetError($type = self::MESSAGE_INDEX,$once = true){
		$key = self::$messageKey . "_error_{$type}";
		$value = Session::Get($key,$once);
		return $value;
	}
	
	public static function SetNotice($message,$type = self::MESSAGE_INDEX){
		$key = self::$messageKey . "_notice_{$type}";
		Session::Set($key, $message);
	}
	
	public static function AddNotice($message,$type = self::MESSAGE_INDEX){
		$notice = strval(self::GetNotice($type,false));
		$notice = "{$notice},{$message}";
		self::SetNotice($notice,$type);
	}
	
	public static function GetNotice($type = self::MESSAGE_INDEX,$once = true){
		$key = self::$messageKey . "_notice_{$type}";
		$value = Session::Get($key,$once);
		return $value;
	}
}