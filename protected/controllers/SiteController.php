<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
		$dataProvider = new CActiveDataProvider('Post');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			$this->temp->session_id = yii::app()->session->getSessionID();
			if($model->validate() && $model->login()){
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	/**
	 * Displays the register page
	 */
	public function actionRegister()
	{
			
			$model = new User('register');
			
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='user-registration-form')
			{
					echo CActiveForm::validate($model);
					Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST['User']))
			{
				$model->attributes=$_POST['User'];
				$password = $model->password;
				if( $model->validate() ){
					if($model->save()) {
						
						$modelLogin = new LoginForm;
						$modelLogin->username = $model->username;
						$modelLogin->password = $password;
						
						$this->temp->session_id = yii::app()->session->getSessionID();
						if($modelLogin->validate() && $modelLogin->login()){
							//redirect the user to page he/she came from
							if(isset($_GET['redirect'])){
								$this->redirect($_GET['redirect']);
							} else {
								$this->redirect(Yii::app()->user->returnUrl);
							}
						} else {
							print_r($modelLogin->getErrors());die;
						}
						
					}
				} else {
					//print_r($model->getErrors());die;
				}      
			}
			// display the register form
			$this->render('register',array('model'=>$model));
	}
}