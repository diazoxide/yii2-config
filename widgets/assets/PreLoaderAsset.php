<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\widgets\assets;

use yii\web\AssetBundle;

class PreLoaderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/diazoxide/yii2-config/assets';

    public $baseUrl = '@web';

    public $css = [];

    public $js = [];

    public $depends = [
        \yii\bootstrap\BootstrapAsset::class,
    ];
}
