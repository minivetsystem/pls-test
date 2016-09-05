<?php

/**
 * Created by PhpStorm.
 * User: minivetssm
 * Date: 30/1/16
 * Time: 1:23 PM
 */
class ArrayHelper
{
    public static function getCostArray(){
        return array(10=>"-10%".Yii::t('app','OF POINTS'), 20=>"-20%".Yii::t('app','OF POINTS'), 40=>"-40%".Yii::t('app','OF POINTS'));
    }

    public static function getQuestionValue(){
        return array(50=>'easy',  75 => 'medium', 100 => 'hard', 200=>'insane');
    }

}