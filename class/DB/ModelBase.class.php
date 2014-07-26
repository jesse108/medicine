<?php
class DB_ModelBase extends DB_Model{
	const ACTOR_TYPE_SYSTEM = 0;
	const ACTOR_TYPE_USER = 1;
	const ACTOR_TYPE_ADMIN = 2;
	
	public function getCurrentUser(){
		$user = Lib_User::getLoginUser();
		if($user){
			return array(
				'actor_type' => self::ACTOR_TYPE_USER,
				'actor_id' => $user['id']
			);
		} else {
			return array(
				'actor_type' => self::ACTOR_TYPE_SYSTEM,
				'actor_id' => 0,
			);
		}
	}
}