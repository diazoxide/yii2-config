<?php

use diazoxide\yii2config\assets\AdminAsset;
use diazoxide\yii2config\Module;
use yii\helpers\Html;

AdminAsset::register($this);

$this->title = Module::t('Modules');
echo Html::tag('h1', $this->title);

?>
<?= Html::a(Module::t('Create'), ['modules/create'],['class'=>'btn btn-danger']) ?>
<?= /** @var \yii\data\ActiveDataProvider $dataProvider */
\yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => yii\grid\SerialColumn::class],
        'name',
        'namespace',
        [
            'attribute' => 'type',
            'value' => function ($model) {
                return \diazoxide\yii2config\models\Modules::getTypeList()[$model->type];
            }
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return \diazoxide\yii2config\models\Modules::getStatusList()[$model->status];
            }
        ],

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
