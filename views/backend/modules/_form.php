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
    <?= $form->field($model, 'type')->dropDownList(\diazoxide\yii2config\models\Modules::getTypeList(),['prompt'=>Module::t('Select Type')]) ?>
    <?= $form->field($model, 'status')->dropDownList(\diazoxide\yii2config\models\Modules::getStatusList()) ?>

    <?= Html::submitButton($model->isNewRecord ? Module::t('Create') : Module::t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>

    <?= $form->errorSummary($model); ?>
    <?php ActiveForm::end(); ?>

    <?php
    //    echo Html::beginForm('', 'post', ['id' => $model->formName().'_tmp']);
    //    echo Html::endForm();
    ?>

    <?php
    /*$js = <<<JS
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.
    window.tmpform = document.getElementById("{$model->formName()}");
    window.tmpform.setAttribute("method", method);
    window.tmpform.setAttribute("action", path);
    var object ={"Modules":{"name":"blog","namespace":"\\diazoxide\\blog\\Module","status":true,"config":{"controllerNamespace":"qwe","backendViewPath":"qerqet"}}};
    function iterate(obj, stack) {
        //for (var property in obj) {
         for (var property in obj) {
            if (obj.hasOwnProperty(property)) {
                if (typeof obj[property] === "object") {
                    iterate(obj[property], stack + '[' + property+']');
                } else {
                    var name = stack + '[' + property+']';
                    var val = obj[property];
                    name = name.replace(/(^\[)(\w+)(\]?)/, function(a, b,c){
                        return c;
                    });
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "text");
                    hiddenField.setAttribute("name", name);
                    hiddenField.setAttribute("value", val);
                    window.tmpform.appendChild(hiddenField);
                }
            }
        }
    }
    iterate(object, '');
    document.body.appendChild(window.tmpform);
    window.tmpform.submit();
}
var form = $('#{$model->formName()}_tmp');
form.jsonForm({
schema: $model->jsonFormSchema,
value: $model->jsonData,
onSubmit: function (errors, values) {
      if (errors) {
        console.log(errors);
      }
      else {
         console.log(JSON.stringify(values));
         post('',values,'post');
      }
}
});
JS;

    $this->registerJs($js)*/
    ?>
</div>
