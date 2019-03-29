<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config;

use diazoxide\yii2config\assets\AdminAsset;
use diazoxide\yii2config\assets\AppAsset;
use diazoxide\yii2config\models\Modules;
use Yii;
use yii\base\ViewNotFoundException;
use yii\db\ActiveRecord;

/**
 * @property array breadcrumbs
 */
class Module extends \yii\base\Module
{
    public $app_ids = [
        'admin' => "Admin",
        'public' => "Public",
        'console' => "Console"
    ];

    public $controllerNamespace = 'diazoxide\yii2config\controllers\frontend';

    public $backendViewPath = '@vendor/diazoxide/yii2-config/views/backend';

    public $frontendViewPath = '@vendor/diazoxide/yii2-config/views/frontend';

    protected $_isBackend;

    public function init()
    {
        parent::init();
        if ($this->getIsBackend() === true) {
            $this->setViewPath($this->backendViewPath);
            AdminAsset::register(Yii::$app->view);
        } else {
            $this->setViewPath($this->frontendViewPath);
            AppAsset::register(Yii::$app->view);
        }
    }


    /**
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('diazoxide/yii2config', $message, $params, $language);
    }

    /**
     * Check if module is used for backend application.
     *
     * @return boolean true if it's used for backend application
     */
    public function getIsBackend()
    {
        if ($this->_isBackend === null) {
            $this->_isBackend = strpos($this->controllerNamespace, 'backend') === false ? false : true;
        }

        return $this->_isBackend;
    }


    /**
     * @return array
     */
    public function getNavigation()
    {
        $items = [
            [
                'label' => Module::t('Config'),
                'items' => [
                    ['label' => Module::t('Modules'), 'url' => ['/'.$this->id.'/modules/index']],
                ]
            ]
        ];

        foreach (Modules::findAll(['status' => Modules::STATUS_ENABLED]) as $module) {

            if (Yii::$app->hasModule($module->name)) {
                $moduleObj = Yii::$app->getModule($module->name);
                if (method_exists($moduleObj, 'getNavigation')) {
                    $items = array_merge($items, $moduleObj->getNavigation());
                }
            }

        }
        return $items;
    }


    /**
     * @return string
     */
    public function getHomeUrl()
    {

        if ($this->getIsBackend()) {
            return Yii::$app->getUrlManager()->createUrl([$this->id . '/default/index']);
        }
        return Yii::$app->getUrlManager()->createUrl([$this->id . '/default/index']);

    }

    /**
     * @return array
     */
    public static function getBreadcrumbs()
    {
        $result = [];
        $result[] = ['label' => Module::t('Config'), 'url' => ['default/index']];
        return $result;
    }

    /**
     * @param $dateStr
     * @param string $type
     * @param null $format
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function convertTime($dateStr, $type = 'date', $format = null)
    {
        if ($type === 'datetime') {
            $fmt = ($format == null) ? Yii::$app->formatter->datetimeFormat : $format;
        } elseif ($type === 'time') {
            $fmt = ($format == null) ? Yii::$app->formatter->timeFormat : $format;
        } else {
            $fmt = ($format == null) ? Yii::$app->formatter->dateFormat : $format;
        }
        return \Yii::$app->formatter->asDate($dateStr, $fmt);
    }

}
