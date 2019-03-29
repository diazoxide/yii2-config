<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@vendor/diazoxide/yii2-config/assets';

    public $baseUrl = '@web';

    public $js = [
//        'js/tooltip.js'
    ];

    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}
