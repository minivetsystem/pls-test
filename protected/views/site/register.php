<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
//$this->breadcrumbs=array(
//	'Register',
//);
?>
<div class="login-form form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-registration-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>true,
    )); ?>

    <div class="top">
        <!--<img class="icon" alt="icon" src="img/kode-icon.png">-->
        <h1><?php echo Yii::t('app','Student')?></h1>
        <h4><?php echo Yii::t('app','Register')?></h4>
        <p class="note"><?php echo Yii::t('app', 'Fields with')?> <span class="required">*</span> <?php echo Yii::t('app', 'are required')?></p>
        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="form-area">

        <div class="group">
            <?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>yii::t('app','Username'))); ?>
            <i class="fa fa-user"></i>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="group">
            <?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>yii::t('app','Password'))); ?>
            <i class="fa fa-key"></i>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <?php echo CHtml::submitButton(Yii::t('app', 'Register'), array('class'=>'btn btn-default btn-block')); ?>
    </div>
    <?php $this->endWidget(); ?>

    <div class="footer-links row">
        <div class="col-xs-6"><a href="<?php echo Yii::app()->getBaseUrl().'index.php?r=site/login'?>"><i class="fa fa-external-link"></i> <?php echo Yii::t('app', 'Login Now')?></a></div>
    </div>

</div><!-- form -->