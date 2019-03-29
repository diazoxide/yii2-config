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

?>
<div>
    <?php
    function rec($options)
    {
        foreach ($options as $option) {
            echo Html::beginTag('li',['class'=>'top-buffer-10-xs']);


            $app_name = $option->app_id ? $option->app_id : Module::t('Common');


            echo Html::beginTag('span', ['class' => 'btn-group ']);
            echo Html::a($option->name, ['option-update', 'id' => $option->id], [
                    'title' => $option->value,
                    'class' => 'btn btn-default btn-xs',
                ]) . ' ';
            echo Html::a($app_name, null, ['class' => 'btn btn-primary disabled btn-xs', 'title' => $app_name]);
            echo Html::a('<i class="fa fa-plus"></i>', ['option-create', 'parent_id' => $option->id], ['class' => 'btn btn-success btn-xs', 'title' => Module::t('Add Option')]);
            echo Html::a('<i class="fa fa-pencil"></i>', ['option-update', 'id' => $option->id], ['class' => 'btn btn-warning btn-xs', 'title' => Module::t('Update Option')]);
            echo Html::a('<i class="fa fa-remove"></i>', ['option-delete', 'id' => $option->id], ['class' => 'btn btn-danger btn-xs', 'title' => Module::t('Delete Option'), 'data-confirm' => Module::t('Are you sure you want to delete this item?'), 'data-method' => 'post', 'data-pjax' => 0]);
            echo Html::endTag('span');


            $children = $option->getChildren()->all();
            if ($children) {
                echo Html::beginTag('ul');
                rec($children);
                echo Html::endTag('ul');
            }

            echo Html::endTag('li');
        }
    }

    echo Html::beginTag('ul');
    rec($options->all());
    echo Html::endTag('ul');

    ?>

</div>

