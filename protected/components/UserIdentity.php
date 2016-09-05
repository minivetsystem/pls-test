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
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$record=User::model()->findByAttributes(array('username'=>$this->username));   
		if($record===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($record->password!==md5($this->password."Laitetaanpa SNADISTI suolaa."))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id = $record->id;
			$this->errorCode=self::ERROR_NONE;
			
		}
		return !$this->errorCode;		
	
	}
	
	public function getId()
	{
		return $this->_id;
	}

	
	/*
		This function could be used to generated test data.
	*/
	public static function createUser($username, $password)
	{
		//self::auth();
		
		$password = md5($password."Laitetaanpa SNADISTI suolaa.");
		$model = new User();
		$model->password = $password;
		$model->username = $username;
		$model->save();
		$auth = Yii::app()->authManager;
		$auth->assign("manager", $model->id);
		
		
		echo "user $username created. ";
		
	}
	
	
	
	//This function works for auth item generation
	public static function auth()
	{	
		$auth = Yii::app()->authManager;
		$auth->clearAll();
		$admin = $auth->createRole("admin", "admin");
		$auth->createRole("manager", "manager");
		$admin->addChild("manager");
		
		$learner = $auth->createRole("learner", "learner");
		$auth->createRole("student", "student");
		$learner->addChild("student");
		
		
		
	}
	
	public static function getRole() 
	{
			$role = Yii::app()->db->createCommand()
					->select('itemname')
					->from('AuthAssignment')
					->where('userid=:id', array(':id'=>Yii::app()->user->id))
					->queryScalar();
	
			return $role;
	}
	
	public static function isAdmin(){
		return self::getRole() == 'admin';
	}

	public static function isStudent(){
		return self::getRole() == 'student';
	}

}