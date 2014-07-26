<?php
include_once dirname(dirname(dirname(__FILE__))).'/app.php';

Lib_User::Logout();

Utility::Redirect("/");
