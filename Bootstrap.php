<?php

namespace diazoxide\yii2config;

use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

/**
 * Blogs module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module URL rules.
//        $app->getUrlManager()->addRules(
//            [
//                '/category/<slug>' => '/blog/default/archive',
//                '/archive' => '/blog/default/archive',
//                [
//                    'pattern' => '<year:\d{4}>/<month:\d{2}>/<day:\d{2}>/<slug>',
//                    'route' => '/blog/default/view',
//                    'suffix' => '/'
//                ],
//                //Fixing old posts issue
//                '/archives/<id:\d+>' => '/site/old-post',
//            ]
//        );
        // Add module I18N category.
        if (!isset($app->i18n->translations['diazoxide/yii2config'])) {
            $app->i18n->translations['diazoxide/yii2config'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'diazoxide/yii2config' => 'blog.php',
                ]
            ];
        }
//        // Add redactor module if not exist (in my case - only in backend)
//        $redactorModule = $this->getModule()->redactorModule;
//        if ($this->getModule()->getIsBackend() && !$app->hasModule($redactorModule)) {
//            $app->setModule($redactorModule, [
//                'class' => 'yii\redactor\RedactorModule',
//                'imageUploadRoute' => ['/blog/upload/image'],
//                'uploadDir' => $this->getModule()->imgFilePath . '/upload/',
//                'uploadUrl' => $this->getModule()->getImgFullPathUrl() . '/upload',
//                'imageAllowExtensions' => ['jpg', 'png', 'gif', 'svg']
//            ]);
//        }
        \Yii::setAlias('@diazoxide', \Yii::getAlias('@vendor') . '/diazoxide');
    }
}