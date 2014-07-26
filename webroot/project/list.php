<?php
include_once dirname(dirname(dirname(__FILE__))).'/app.php';
$user = Lib_User::NeedLogin();

$projects = Lib_Project::GetList($user['id']);

