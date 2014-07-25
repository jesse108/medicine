<?php
class DB_Model{
	public $tableName = '';
	public $error = '';
	public $readDB ='ro';
	public $writeDB = 'rw';
	public $primaryKey = 'id';
	public $logTable = '';
	
	
	public function create($condition,$duplicateCondition = null){
		$table = $this->tableName;
		if(!$table){
			$this->error = 'Table name is null';
			return false;
		}
		$insertID = DB::Insert($table, $condition,$duplicateCondition,$this->writeDB);
		if(!$insertID){
			$this->error = DB::$error;
		}
		return $insertID;
	}
	
	public function get($condition,$option = array()){
		$table = $this->tableName;
		$dbType = $dbType ? $dbType : $this-> readDB;
		if(!$table){
			$this->error = 'Table name is null';
			return false;
		}
		$result = DB::LimitQuery($table,$condition,$option,$dbType);
		if(!$result){
			$this->error = DB::$error;
		}
		return $result;
	}
	
	public function update($condition,$updateRow){
		$result = DB::Update($this->tableName, $condition, $updateRow,$this->writeDB);
		return $result;
	}
	
	public function count($condition,$sum =null){
		$count  = DB::Count($this->tableName, $condition);
		$count = intval($count);
		return $count;
	}
	
	
	public function fetch($id,$key = null){
		if(!$id){
			return false;
		}
		
		$key = $key ? $key : $this->primaryKey;
		
		$condition = array(
			$key => $id,
		);
		
		if(Util_Array::IsArrayValue($id)){
			$one = false;
		} else {
			$one = true;
		}
		$option =array('one' => $one);
		
		$result = DB::LimitQuery($this->tableName,$condition,$option,$this->readDB);
		if(!$result){
			$this->error = DB::$error;
		}
		return $result;
	}
	
	public function exsits($condition,$column = 'id'){
		return DB::Exists($this->tableName, $condition,$column,$this->readDB);
	}
}