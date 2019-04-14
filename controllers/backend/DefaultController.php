<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\controllers\backend;

use diazoxide\yii2config\Module;
use Yii;
use yii\web\Controller;

/**
 *
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

    public function actionClearCache()
    {

        Yii::$app->cache->flush();

        Yii::$app->session->setFlash('success', Module::t('Cache successfully cleared.'));

        $this->redirect(Yii::$app->request->referrer);
    }
}
