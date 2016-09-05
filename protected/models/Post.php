<?php

Yii::import('application.models._base.BasePost');

class Post extends BasePost
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	protected function beforeValidate()
	{

		$this->writer_id = Yii::app()->user->getId();
		$this->created_at = date('Y-m-d H:i:s');

		return parent::beforeValidate();

	}
}