<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $temp;
	
	public function init(){
		$this->temp = new stdClass;	
		new JsTrans('app',Yii::app()->language);
	} 
	
	public function putScoreAfterLogin(){
		$model = new Score;

		if(!Yii::app()->user->isGuest){
			return $model->updateAll(
				array(
						'user_id'=>Yii::app()->user->getId(),
						'session_id'=>''
					),
				"session_id=:session_id",
				array(':session_id'=>$this->temp->session_id));
		} else {
			return false;	
		}
			
	}

	public function getThemeAssetsUrl(){
		return Yii::app()->getBaseUrl().'/themes/'.Yii::app()->theme->name.'/assets/';
	}
}