<?php
include_once dirname(dirname(dirname(__FILE__))).'/app.php';

$id = $_REQUEST['id'];

$project = Lib_Project::Fetch($id);
if(!$project){
	Utility::Redirect();
}


