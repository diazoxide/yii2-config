<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use diazoxide\yii2config\Module;

/* @var $this yii\web\View */

$this->title = Module::t('Create ') . Module::t('Module');
$this->params['breadcrumbs'][] = ['label' => Module::t('Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
