<?php
class Lib_Project{
	const STATUS_NORMAL = 0;
	
	public static function GetList($userID){
		$condition = array(
			'owner_id' => $userID,
			'status' => self::STATUS_NORMAL,
		);
		$dbProject = DB_Manage::createDBObj('project');
		$projects = $dbProject->get($condition);
		
		if(!$projects){
			System::AddError($dbProject->error);
			return false;
		}
		$projects = Util_Array::AssColumn($projects, 'id');
		return $projects;
	}
	
	public static function Fetch($id){
		$dbProject = DB_Manage::createDBObj('project');
		$project = $dbProject->fetch($id);
		
		if(!$project){
			System::AddError('项目ID错误');
			return false;
		}
		
		if($project['status'] != self::STATUS_NORMAL){
			System::AddError('此项目不能查看');
		}
		
		return $project;
	}
	
	
	public static function Create($project){
		$dbProject = DB_Manage::createDBObj('project');
		$id = $dbProject->create($project);
		if(!$id){
			System::AddError("创建失败" . $dbProject->error);
		}
		return $id;
	}
	
	public static function Update($project,$updateRow){
		$dbProject = DB_Manage::createDBObj('project');
		$result = $dbProject->update($project['id'], $updateRow,$project);
		if(!$result){
			System::AddError('更新失败:'.$dbProject->error);
		}
		
		return $result;
	}
	
	/**
	 * 邀请项目成员
	 */
	public static function InviteMember($project,$members){
		
	}
	
	
}