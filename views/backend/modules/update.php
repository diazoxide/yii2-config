<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use diazoxide\yii2config\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

/** @var \diazoxide\yii2config\models\Modules $model */
$this->title = Module::t('Update ') . Module::t('Module') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('Config'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>
<div class="blog-post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


