<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function relations()
	{
		return CMAP::mergeArray(
			array(
			), parent::relations());
	}



	public function rules()
	{

		$prerules = CMAP::mergeArray(array(
			array('username, password', 'required', 'on' => 'register'),
			array('username', 'unique', 'on' => 'register'),
			array('roles', 'safe')
		), parent::rules());

		return $prerules;
	}

	//calling hash to encrypt given password
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if (isset($_POST['User']['password'])) {
				$this->password = md5($this->password . "Laitetaanpa SNADISTI suolaa.");
			}
			return true;
		}
		return false;
	}
}