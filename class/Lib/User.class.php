<?php
class Lib_User{	
	const STATUS_NORMAL = 0; //正常状态
	
	
	public static $error = '';
	public static $loginUser = array();
	
	public static function Login($name,$password){
		if(!$name || !$password){
			return false;
		}
		$dbUser = DB_Manage::createDBObj('user');
		$user = $dbUser->fetch($name,'email');
		if(!$user || $user['password'] != md5($password)){
			System::AddError("账号或密码错误");
			return false;
		}
		
		if($user['status'] != self::STATUS_NORMAL){
			System::AddError("用户状态错误");
			return false;			
		}
		
		Session::Set(SESSION_LOGIN_USER_ID, $user['id']);
		self::$loginUser = $user;
		return $user;
	}
	
	public static function NeedLogin($redirectUrl = '/user/login.php'){
		$loginUser = self::GetLoginUser();
		if(!$loginUser){
			System::AddError("请先登录");
			Utility::SetReturnUrl();
			Utility::Redirect($redirectUrl);
		}
		return $loginUser;
	}
	
	public static function GetLoginUser(){
		if(self::$loginUser){
			return self::$loginUser;
		}
		
		$loginUserID = Session::Get(SESSION_LOGIN_USER_ID);
		if(!$loginUserID){
			return false;
		}
		$dbUser = DB_Manage::createDBObj('user');
		$user = $dbUser->fetch($loginUserID);
		
		if($user['status'] != self::STATUS_NORMAL){
			self::Logout();
			return false;
		}
		return $user;
	}
	
	
	public static function Logout(){
		self::$loginUser = array();
		Session::Del(SESSION_LOGIN_USER_ID);
		return true;
	}
}