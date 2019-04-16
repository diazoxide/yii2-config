<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use diazoxide\yii2config\assets\AdminAsset;
use diazoxide\yii2config\Module;

AdminAsset::register($this);

/* @var $this yii\web\View */

/** @var \diazoxide\yii2config\models\Modules $model */

$this->title = Module::t('Update ') . Module::t('Module') . ' ' . $model->name;
$this->params['breadcrumbs'] = $model->breadcrumbs;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


