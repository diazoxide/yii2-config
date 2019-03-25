<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \diazoxide\yii2config\Module;

/* @var $this yii\web\View */
/* @var $model \diazoxide\yii2config\models\Modules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-12 text-right">
            <?= Html::submitButton($model->isNewRecord ? Module::t('Create') : Module::t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        </div>
    </div>


    <div class="row top-buffer-20">
        <div class="col-md-6">

            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'namespace')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'status')->dropDownList(\diazoxide\yii2config\models\Modules::getStatusList()) ?>

        </div>
        <div class="col-md-6">
            <?php
            if ($model->properties) {
                foreach ($model->properties as $key => $property) {

                    echo $form->field($model, "config[{$property['name']}]")
                        ->textInput(['maxlength' => 255])->label($property['name'])
                        ->hint(Module::t('Default value is: ').var_export($property['value'],true));
                }
            }
            ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
