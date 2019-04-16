<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use diazoxide\yii2config\assets\AdminAsset;
use diazoxide\yii2config\Module;
use yii\helpers\Html;

AdminAsset::register($this);

/* @var $this yii\web\View */

/** @var \diazoxide\yii2config\models\ModulesOptions $model */
$this->title = Module::t('Update ') . Module::t('Module') . ' ' . $model->name;
$this->params['breadcrumbs'] = $model->breadcrumbs;
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>
<div class="blog-post-update">

    <?= $this->render('_form_option', [
        'model' => $model,
    ]) ?>

    <?php if ($model->is_object): ?>
        <h3><?= Module::t('Options') ?></h3>
        <p><?= Html::a(Module::t('Create'), ['option-create', 'id' => $model->module_id, 'parent_id' => $model->id], ['class' => 'btn btn-success']); ?></p>
        <?php
        echo $this->render('_options', [
            'model' => $model,
            'options' => $model->getOptions(),
        ]); ?>
    <?php endif; ?>

</div>


