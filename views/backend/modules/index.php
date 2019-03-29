<?php

use diazoxide\yii2config\Module;
use yii\helpers\Html;

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
            'attribute' => 'status',
            'value' => function ($model) {
                return \diazoxide\yii2config\models\Modules::getStatusList()[$model->status];
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
