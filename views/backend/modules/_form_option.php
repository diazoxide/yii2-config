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
/* @var $model \diazoxide\yii2config\models\ModulesOptions */
/* @var $form yii\widgets\ActiveForm */
\diazoxide\yii2config\assets\JsonformAsset::register($this);
?>

<div class="blog-post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?php
    $options = [
        'prompt' => Module::t('Select Property Type'),
        'onclick' => new \yii\web\JsExpression('this.removeAttribute("readonly")')
    ];

    if ($model->type) {
        $options['readonly'] = 'readonly';
    }

    echo $form->field($model, 'type_id')->dropDownList($model::getTypesList(), $options) ?>

    <?php switch ($model->type) {
        case $model::TYPE_INTEGER:
            echo $form->field($model, 'value')->textInput(['type' => 'number']);
            break;
        case $model::TYPE_STRING:
            echo $form->field($model, 'value')->textInput(['maxlength' => 255]);
            break;
        case $model::TYPE_TEXT:
            echo $form->field($model, 'value')->textarea(['rows' => 10]);
            break;
        case $model::TYPE_BOOLEAN:
            echo $form->field($model, 'value')->dropDownList([false => Module::t('No'), true => Module::t('Yes')]);
            break;
        case $model::TYPE_TEXT_CSS:
            echo $form->field($model, 'value')->widget(trntv\aceeditor\AceEditor::class, ['mode' => 'css', 'theme' => 'github']);
            break;
        case $model::TYPE_TEXT_JS:
            echo $form->field($model, 'value')->widget(trntv\aceeditor\AceEditor::class, ['mode' => 'javascript', 'theme' => 'github']);
            break;
        case $model::TYPE_TEXT_HTML:
            echo $form->field($model, 'value')->widget(trntv\aceeditor\AceEditor::class, ['mode' => 'html', 'theme' => 'github']);
            break;
        case $model::TYPE_TEXT_HTML_RICH:
            echo $form->field($model, 'value')->widget(trntv\aceeditor\AceEditor::class, ['mode' => 'html', 'theme' => 'github']);
            break;
        default:
            echo $form->field($model, 'value')->textInput(['maxlength' => 255]);
            break;

    } ?>
    <?= $form->field($model, 'app_id')->dropDownList($this->context->module->app_ids, ['prompt' => Module::t('Common')]) ?>
    <?= $form->field($model, 'is_object')->dropDownList([false => Module::t('No'), true => Module::t('Yes')]) ?>

    <?= Html::submitButton($model->isNewRecord ? Module::t('Create') : Module::t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    <?= $form->errorSummary($model); ?>
    <?php ActiveForm::end(); ?>

</div>
