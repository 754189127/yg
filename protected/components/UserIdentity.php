<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $userInfoModel;
	
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
		$userModel = new User();
        $userInfo = $userModel->safeLogin($this->username,$this->password);
        $this->userInfoModel = $userInfo;
      
        if(is_null($userInfo))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($userInfo === -1)      // 账号IP受限
			$this->errorCode = 10;     
		else if($userInfo === -2)      // 账号过期
			$this->errorCode = 11;	   
		else{        
            $this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
}