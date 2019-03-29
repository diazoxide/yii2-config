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

/** @var string $app_id */
/* @var $this yii\web\View */

/** @var \diazoxide\yii2config\models\Modules $model */
$this->title = Module::t('View ') . Module::t('Module') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('Config'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>
<div>

    <h1><?= $model->name ?></h1>
    <h3><?= $model->namespace ?></h3>
    <?= Html::a(Module::t('Options'), ['options', 'id' => $model->id], ['class' => 'btn btn-default']) ?>

    <?= Html::a(Module::t('Update'), ['modules/update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

    <h4><?= Module::t("Configs") ?></h4>

    <?php
    $items = [];
    foreach ($this->context->module->app_ids as $app_id => $app_name) {
        $items[] = [
            'label' => $app_name,
            'content' => '<pre>'.var_export($model->getConfig($app_id), true).'</pre>',
            'options' => ['id' => 'conf_'.$app_id],

        ];
    }
    echo \yii\bootstrap\Tabs::widget([
        'items' => $items
    ])
    ?>
</div>


