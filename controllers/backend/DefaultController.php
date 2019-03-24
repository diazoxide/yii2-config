<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\blog\controllers\backend;

use diazoxide\yii2config\Module;
use Yii;
use yii\web\Controller;

/**
 * @property Module module
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
}
