<?php
/**
 * 模板类  这里直接使用smarty模板
 * @author zhaojian
 *
 */
class Template{
	const DEFAULT_TEMPLATE_SUFFIX = '.html';
	public $smarty;
	
	
	public static function Show($template ='',$parameters = array(),$assignGlobal = true){
		$smarty = self::GetTemplate();
		if($assignGlobal){
			$smarty = self::AssignGlobalVar($smarty);
		}
		
		foreach ($parameters as $key => $val){
			$smarty->assign($key,$val);
		}
		
		if(!$template){
			$webroot = Config::Get('webroot');
			$path = $_SERVER['PHP_SELF'];
			
			if(trim($webroot,'/')){
				$webroot = strtr($webroot, array('/' => "\\/","\\" => "\\/"));
				$path = preg_replace("/$webroot/", '', $path,1);
			}
	
			$path = trim($path,'/');
			$dotPos = strpos($path,'.');
			if($dotPos !== false){
				$path  = substr($path, 0,$dotPos);
			}
			$template = $path . self::DEFAULT_TEMPLATE_SUFFIX;
		}
		$smarty->display($template);
	}
	
	public static function GetTemplate(){
		$smarty = new Smarty();
		$smarty->setTemplateDir(TEMPLATE_PATH);
		$smarty->setCompileDir(COMPILE_PATH);
		$smarty->setConfigDir(CONF_PATH);
		$smarty->setCacheDir(CACHE_PATH);
		return $smarty;
	}
	
	public static function AssignGlobalVar(&$smarty){
		foreach ($GLOBALS as $key => $val){
			$smarty->assign($key,$val);
		}
		return $smarty;
	}
}