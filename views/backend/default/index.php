<?php
/**
 * Created by PhpStorm.
 * User: Yordanyan
 * Date: 25.03
 * Time: 02:01
 */

use diazoxide\yii2config\Module;
use yii\helpers\Html;

$this->title = Module::t('Config Module');
echo Html::tag('h1', $this->title);

?>

<div>
    <div class="btn-group">
        <?= Html::a(Module::t('Clear cache'), ['clear-cache'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
