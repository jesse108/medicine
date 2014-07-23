<?php
include_once dirname(dirname(dirname(__FILE__))).'/app.php';

$cacheKey = CACHE_TEST;
$data = "Cache Test Data";
$cacheExpire = 60;//60分钟


$cacheConfig = Config::Get('cache');
$cache = Cache_Manage::getInstance($cacheConfig);



dump($cache->set($cacheKey,$data,$cacheExpire)); //设置



dump($cache->get($cacheKey)); //获取