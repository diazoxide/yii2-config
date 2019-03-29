<?php
use diazoxide\yii2config\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

/** @var \diazoxide\yii2config\models\Modules $model */
$this->title = Module::t('Options ');
$this->params['breadcrumbs'] = $model->breadcrumbs;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= $model->name ?></h1>
    <h3><?= Module::t('Options') ?></h3>
    <p><?= Html::a(Module::t('Create'), ['option-create', 'module_id' => $model->id],['class'=>'btn btn-success']); ?></p>

    <?= $this->render('_options', [
        'options' => $options
    ]) ?>
</div>


