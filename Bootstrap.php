<?php

namespace diazoxide\yii2config;

use diazoxide\yii2config\models\Modules;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use yii\web\Application;

/**
 * Blogs module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    protected $modules = [];
    protected $components = [];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        if (!isset($app->i18n->translations['diazoxide/yii2config'])) {
            $app->i18n->translations['diazoxide/yii2config'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'diazoxide/yii2config' => 'yii2config.php',
                ]
            ];
        }

        $modules = Modules::findAll(['status' => Modules::STATUS_ENABLED]);
        foreach ($modules as $module) {

            switch ($module->type) {
                case Modules::TYPE_MODULE:
                    if (!$app->hasModule($module->name)) {
                        $this->modules[$module->name] = $module->getConfig($app->id);
                        if ($module->is_bootstrap) {
                            $bootstrap = new $module->bootstrap_namespace;
                            $bootstrap->{$module->bootstrap_method}($app);
                        }
                    }
                    break;
                case Modules::TYPE_COMPONENT:
                    $this->components[$module->name] = $module->getConfig($app->id);
                    break;
            }

        }

        $app->setComponents($this->components);
        $app->setModules($this->modules);


        \Yii::setAlias('@diazoxide', \Yii::getAlias('@vendor') . '/diazoxide');
    }
}