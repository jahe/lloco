<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $id;
	
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('username' => $this->username));
		
		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if ($user->password !== $this->password)
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->id = $user->username;
			$this->errorCode = self::ERROR_NONE;
		}
		
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->id;
	}
}