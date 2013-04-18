<?php

class User extends EMongoDocument
{
	public $username;
	public $password;
	public $email;
	
	public function getCollectionName()
	{
		return 'users';
	}
	
	public function rules()
	{
		return array(
			array('username, password, email', 'required'),
			//array('username', 'unique')
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

?>