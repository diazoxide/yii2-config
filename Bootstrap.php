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
    protected $modules = [
        'components' => [],
        'modules' => [],
    ];

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

        $cache = $app->cache;

        $cache_id = 'yii2config_components_' . $app->id;
        if (!$this->modules = $cache->get($cache_id)) {

            $modules = Modules::find()->where(['status' => Modules::STATUS_ENABLED])->orderBy(['priority' => SORT_ASC])->all();
            foreach ($modules as $module) {

                switch ($module->type) {
                    case Modules::TYPE_MODULE:
                        if (!$app->hasModule($module->name)) {
                            $this->modules['modules'][$module->name] = $module->getConfig($app->id);
                            if ($module->is_bootstrap) {
                                $bootstrap = new $module->bootstrap_namespace;
                                $bootstrap->{$module->bootstrap_method}($app);
                            }
                        }
                        break;
                    case Modules::TYPE_COMPONENT:
                        $this->modules['components'][$module->name] = $module->getConfig($app->id);
                        break;
                }

            }
            //Устанавливаем зависимость кеша от кол-ва записей в таблице
            $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT SUM(updated_at) FROM ' . Modules::tableName()]);
            $cache->set($cache_id, $this->modules, null, $dependency);
        }


        if (isset($this->modules['components'])) {
            $app->setComponents($this->modules['components']);
        }
        if (isset($this->modules['modules'])) {
            $app->setModules($this->modules['modules']);
        }

        \Yii::setAlias('@diazoxide', \Yii::getAlias('@vendor') . '/diazoxide');
    }
}