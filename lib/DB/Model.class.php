<?php
class DB_Model{
	public $tableName = '';
	public $error = '';
	public $readDB ='ro';
	public $writeDB = 'rw';
	public $primaryKey = 'id';
	public $logTable = '';
	public $useLog = true;
	
	
	public function create($condition,$duplicateCondition = null,$actorType = 0,$actorID = 0){
		$table = $this->tableName;
		if(!$table){
			$this->error = 'Table name is null';
			return false;
		}
		$insertID = DB::Insert($table, $condition,$duplicateCondition,$this->writeDB);
		if(!$insertID){
			$this->error = DB::$error;
		}
		
		$this->log($insertID, '', $condition, DB_Log::TYPE_CREATE,$actorType,$actorID);
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
	
	public function update($condition,$updateRow,$oldCondition = null,$actorType = 0,$actorID = 0){
		if(!is_array($condition)){
			$condition = array($this->primaryKey => $condition);
		}
		$result = DB::Update($this->tableName, $condition, $updateRow,$this->writeDB);
		if($result){
			$this->log($oldCondition[$this->primaryKey], $oldCondition, $updateRow, DB_Log::TYPE_UPDATE,$actorType,$actorID);
		} else {
			$this->error = DB::$error;
		}
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
	
	public function exsits($condition,$column = ''){
		$column = $column ? $column : $this->primaryKey;
		return DB::Exists($this->tableName, $condition,$column,$this->readDB);
	}
	
	
	public function log($tableID,$oldData,$updateData,$type,$actorType = 0,$actorID = 0){
		if(!$this->logTable || !$this->useLog){
			return false;
		}
		
		$log = new DB_Log($this->logTable);
		
		if(!$actorType && !$actorID){
			$currentUser = $this->getCurrentUser();
			if($currentUser){
				$actorType = $currentUser['actor_type'];
				$actorID = $currentUser['actor_id'];
			}
		}
		return $log->log($this->tableName, $tableID, $oldData, $updateData, $type, $actorType, $actorID);
	}
	
	/**
	 * 获取当前用户， 需要覆盖使用
	 */
	public function getCurrentUser(){
		return false;
	}
}