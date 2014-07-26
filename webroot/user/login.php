<?php
include_once dirname(dirname(dirname(__FILE__))).'/app.php';


if($_POST){
	$name = $_POST['email'];
	$pwd = $_POST['pwd'];
	$user = Lib_User::Login($name, $pwd);
	if($user){
		Utility::Redirect();
	}
}