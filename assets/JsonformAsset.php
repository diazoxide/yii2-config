<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class JsonformAsset extends AssetBundle
{
    public $sourcePath = '@bower/jsonform';

    public $baseUrl = '@web';

    public $css = [
        'deps/opt/bootstrap.css'
    ];

    public $js = [
        'deps/underscore.js',
        'deps/opt/jsv.js',
        'lib/jsonform.js'
    ];
    public $depends = [
        JqueryAsset::class
    ];
}
