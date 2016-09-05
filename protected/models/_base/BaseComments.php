<?php

/**
 * This is the model base class for the table "comments".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Comments".
 *
 * Columns in table "comments" available as properties of the model,
 * followed by relations of table "comments" available as properties of the model.
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $text
 * @property string $created_at
 *
 * @property Post $post
 * @property User $user
 */
abstract class BaseComments extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'comments';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Comments|Comments', $n);
	}

	public static function representingColumn() {
		return 'text';
	}

	public function rules() {
		return array(
			array('post_id, user_id, text, created_at', 'required'),
			array('post_id, user_id', 'numerical', 'integerOnly'=>true),
			array('id, post_id, user_id, text, created_at', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'post_id' => null,
			'user_id' => null,
			'text' => Yii::t('app', 'Text'),
			'created_at' => Yii::t('app', 'Created At'),
			'post' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('post_id', $this->post_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('created_at', $this->created_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}