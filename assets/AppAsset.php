<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/diazoxide/yii2-config/assets/default';

    public $baseUrl = '@web';

    public $css = [];

    public $js = [];

    public $depends = [
        \yii\bootstrap\BootstrapAsset::class,
    ];
}
