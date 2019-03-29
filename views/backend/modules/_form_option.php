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
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'app_id')->dropDownList($this->context->module->app_ids,['prompt'=>Module::t('Common')]) ?>
    <?= $form->field($model, 'is_object')->dropDownList([false => Module::t('No'), true => Module::t('Yes')]) ?>

    <?= Html::submitButton($model->isNewRecord ? Module::t('Create') : Module::t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    <?= $form->errorSummary($model); ?>
    <?php ActiveForm::end(); ?>

</div>
