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
\diazoxide\yii2config\assets\JsonformAsset::register($this);
?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'id' => $model->formName()],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'namespace')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'is_bootstrap')->dropDownList([false => Module::t('No'), true => Module::t('Yes')]) ?>
    <?= $form->field($model, 'bootstrap_namespace')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'bootstrap_method')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'type')->dropDownList(\diazoxide\yii2config\models\Modules::getTypeList(), ['prompt' => Module::t('Select Type')]) ?>
    <?= $form->field($model, 'priority')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'status')->dropDownList(\diazoxide\yii2config\models\Modules::getStatusList()) ?>

    <?= Html::submitButton($model->isNewRecord ? Module::t('Create') : Module::t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    <?= $form->errorSummary($model); ?>
    <?php ActiveForm::end(); ?>

</div>
