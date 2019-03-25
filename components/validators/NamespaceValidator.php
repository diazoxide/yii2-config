<?php

namespace diazoxide\yii2config\components\validators;
use yii\validators\Validator;

class NamespaceValidator extends Validator
{
    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (!class_exists($model->$attribute)) {
            $this->addError($model, $attribute, 'The class not found!');
        }
    }
}