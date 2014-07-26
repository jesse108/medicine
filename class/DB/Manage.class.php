<?php
class DB_Manage{
	public static function createDBObj($tableName,$logTable = ''){
		$className = "DB_";
		$tableNames = explode('_', $tableName);
		foreach ($tableNames as $name){
			$name = ucfirst($name);
			$className .= "{$name}";
		}
		
		if(class_exists($className)){
			$obj = new $className();
			return $obj;
		}
		
		$obj = new DB_ModelBase();
		$obj->tableName = $tableName;
		$obj->logTable = $logTable;

		return $obj;
	}
}