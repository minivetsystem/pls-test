<?php

/**
 * TabularInputManager is a class of utility for manage tabular input.
 * it supplies all utlity necessary for create, save models in tabular input
 * IMPORTANT! Requires an input field with the id to work.
 */
class XTabularInputManager extends CComponent {

    /**
     * @var array from the post data.
     */
    public $postData;
    public $className;
    public $belongsToColumnName;
    public $belongsToIdValue;
    public $models;
    public $newModels;
    public $validateTrue;

    /**
     * Main function of the class.
     * load the items from db and applys modification
     * @return boolean whether the all models are valid or not.
     */
    public function insertAndValidate() {

        $isValid = true;
        //Then creating new items 
        foreach ($this->postData as $index => $attributes) {
            $className = $this->className;
            if (isset($attributes['id']) === true && empty($attributes['id']) === false) {
                $model = $className::model()->findByPk($attributes['id']);
            } else {
                $model = new $this->className;
            }

            $model->attributes = $attributes;
            $model->{$this->belongsToColumnName} = $this->belongsToIdValue;

            if (!$model->validate())
                $isValid = false;
            $this->newModels[$index] = $model;

            unset($model);
        }
        $this->validateTrue = $isValid;


        return $this->newModels;
    }

    public function save($callback = '') {
        $count = 0;
        $stillExistingIds = array();
        foreach ($this->newModels as $model) {
            if ($model->isNewRecord === false) {
                $stillExistingIds[] = $model->id;
            }

            if ($model->save()) {
                if ($callback != '') {
                    $model->$callback($model->id, $count);
                }
            }
            $count++;
        }

        foreach ($this->models as $oldModel) {
            if (in_array($oldModel->id, $stillExistingIds) === false) {
                $oldModel->delete();
            }
        }
        return $this->newModels;
    }

    public function getModels() {
        if (!isset($this->models)) {
            if (isset($this->belongsToIdValue)) {
                $className = $this->className;
                $this->models = $className::model()->findAll("{$this->belongsToColumnName} = {$this->belongsToIdValue}");
            } else {
                $this->models = array();
            }
        } else {
            $this->models = array();
        }
        return $this->models;
    }

    /**
     * @deprecated This doesn't seem to be used anywhere and it doesn't seem to have a use.
     * If there is a use case for it, then it still needs to be fixed to not delete all models before saving them to the database again.
     */
    public function saveDontDel() {
        // foreach($this->models as $model)
        // 	$model->delete();
        // foreach($this->newModels as $model)
        // {
        // 	$model->{$this->belongsToColumnName} = $this->belongsToIdValue;		
        // 	$model->save();		
        // }
        // return $this->newModels;
    }

}
