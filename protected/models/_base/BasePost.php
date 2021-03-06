<?php

/**
 * This is the model base class for the table "post".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Post".
 *
 * Columns in table "post" available as properties of the model,
 * followed by relations of table "post" available as properties of the model.
 *
 * @property integer $id
 * @property integer $writer_id
 * @property string $title
 * @property string $text
 * @property string $created_at
 *
 * @property Comments[] $comments
 * @property User $writer
 */
abstract class BasePost extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'post';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Post|Posts', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('writer_id, title, text, created_at', 'required'),
			array('writer_id', 'numerical', 'integerOnly'=>true),
			array('id, writer_id, title, text, created_at', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'comments' => array(self::HAS_MANY, 'Comments', 'post_id'),
			'writer' => array(self::BELONGS_TO, 'User', 'writer_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'writer_id' => null,
			'title' => Yii::t('app', 'Title'),
			'text' => Yii::t('app', 'Text'),
			'created_at' => Yii::t('app', 'Created At'),
			'comments' => null,
			'writer' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('writer_id', $this->writer_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('created_at', $this->created_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}