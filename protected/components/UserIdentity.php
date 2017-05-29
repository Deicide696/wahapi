<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		// $users=array(
		// 	// username => password
		// 	'demo'=>'demo',
		// 	'admin'=>'admin',
		// );

		$user = Users::model()->find('LOWER(email)=?', array(strtolower($this->username)));

		// if(!isset($users[$this->username]))
		if($user === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		// elseif($users[$this->username]!==$this->password)
		elseif(sha1($this->password)!==$user->pwd)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->_id;
			$this->setState('email', $user->email);
			$this->setState('userId', $user->_id);
			$this->setState('name', $user->name);
			$this->setState('last_name', $user->last_name);
			$this->errorCode=self::ERROR_NONE;			
		}

		return !$this->errorCode;
	}
}