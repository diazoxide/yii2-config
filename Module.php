<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config;

use diazoxide\yii2config\assets\AdminAsset;
use diazoxide\yii2config\assets\AppAsset;
use Yii;
use yii\base\ViewNotFoundException;
use yii\db\ActiveRecord;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'diazoxide\yii2config\controllers\frontend';

    public $backendViewPath = '@vendor/diazoxide/yii2-config/views/backend';

    public $frontendViewPath = '@vendor/diazoxide/yii2-config/views/frontend';

    public $frontendViewsMap = [];

    public $frontendLayoutMap = [];

    public $frontendTitleMap = [];

    protected $_frontendViewsMap = [
        'config/default/index' => 'index',
        'config/default/view' => 'view',
        'config/default/archive' => 'archive',
        'config/default/book' => 'viewBook',
        'config/default/chapter' => 'viewChapter',
        'config/default/chapter-search' => 'searchBookChapter',
    ];

    public $urlManager = 'urlManager';

    public $imgFilePath = '@frontend/web/img/congig';

    public $imgFileUrl = '/img/config';

    /** @var ActiveRecord user (for example, 'common\models\User::class' */
    public $userModel;// = \common\models\User::class;

    /** @var string Primary Key for user table, by default 'id' */
    public $userPK = 'id';

    /** @var string username uses in view (may be field `username` or `email` or `login`) */
    public $userName = 'username';


    protected $_isBackend;

    /**
     * @return mixed|string
     */
    public function getView()
    {
        $route = Yii::$app->controller->route;

        if ($this->getIsBackend() !== true) {

            if (isset($this->frontendViewsMap[$route])) {

                return $this->frontendViewsMap[$route];

            } elseif (isset($this->_frontendViewsMap[$route])) {

                return $this->_frontendViewsMap[$route];

            }
        }
        throw new ViewNotFoundException('The view file does not exist.');
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
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
     * Need correct Full IMG URL for Backend
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getImgFullPathUrl()
    {
        return \Yii::$app->get($this->urlManager)->getHostInfo() . $this->imgFileUrl;
    }

    public static function getNavigation()
    {
        return [
            ['label' => 'Posts', 'url' => ['/blog/blog-post'], 'visible' => Yii::$app->user->can("BLOG_VIEW_POSTS")],
            ['label' => 'Categories', 'url' => ['/blog/blog-category'], 'visible' => Yii::$app->user->can("BLOG_VIEW_CATEGORIES")],
            ['label' => 'Comments', 'url' => ['/blog/blog-comment'], 'visible' => Yii::$app->user->can("BLOG_VIEW_COMMENTS")],
            ['label' => 'Tags', 'url' => ['/blog/blog-tag'], 'visible' => Yii::$app->user->can("BLOG_VIEW_TAGS")],
            ['label' => 'Widget Types', 'url' => ['/blog/widget-type/index'], 'visible' => Yii::$app->user->can("BLOG_VIEW_WIDGET_TYPES")],
        ];
    }


    public function getHomeUrl()
    {

        if ($this->getIsBackend()) {
            return Yii::$app->getUrlManager()->createUrl([$this->id . '/default/index']);
        }
        return Yii::$app->getUrlManager()->createUrl([$this->id . '/default/index']);

    }

    public function getBreadcrumbs()
    {
        $result = [];
        $result[] = ['label' => Module::t('Config'), 'url' => $this->homeUrl];
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
