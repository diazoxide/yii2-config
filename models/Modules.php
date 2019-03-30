<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\models;


use diazoxide\yii2config\components\validators\NamespaceValidator;
use diazoxide\yii2config\Module;
use ReflectionProperty;

/**
 * @property string $id
 * @property string $name
 * @property string $namespace
 * @property boolean $status
 * @property boolean $is_bootstrap
 * @property string $bootstrap_namespace
 * @property string $bootstrap_method
 * @property ModulesOptions[] options
 */
class Modules extends \yii\db\ActiveRecord
{

    const STATUS_ENABLED = true;
    const STATUS_DISABLED = false;

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ENABLED => Module::t('Enabled'),
            self::STATUS_DISABLED => Module::t('Disabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config_modules}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'namespace', 'status'], 'required'],
            [['name', 'namespace','bootstrap_namespace','bootstrap_method'], 'string', 'max' => 255],
            [['namespace','bootstrap_namespace'], NamespaceValidator::class],
            [['is_bootstrap', 'status'], 'boolean'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'name' => Module::t('Name'),
            'namespace' => Module::t('Namespace'),
            'bootstrap_namespace' => Module::t('Bootstrap Namespace'),
            'is_bootstrap' => Module::t('Is Bootstrap'),
        ];
    }

    public function saveOptions($properties, $parent = null)
    {

        foreach ($properties as $key => $value) {

            $model = new ModulesOptions();
            $model->module_id = $this->id;
            $model->name = strval($key);
            if (is_array($value)) {
                $model->is_object = true;
                if ($parent) {
                    $model->prependTo($parent)->save();
                } else {
                    $model->makeRoot()->save();
                }
                $this->saveOptions($value, $model);
            } else {
                $model->value = strval($value);
                if ($parent) {
                    $model->prependTo($parent)->save();
                } else {
                    $model->makeRoot()->save();
                }

            }
        }
    }


    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \ReflectionException
     */
    public function afterSave($insert, $changedAttributes)
    {

        if ($insert) {
            $this->saveOptions($this->getClassDefaultProperties());
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(ModulesOptions::class, ['module_id' => 'id'])->andWhere(['parent_id' => null]);
    }

    public function getOption($name)
    {
        return $this->getOptions()->andWhere(['name' => $name])->one();
    }

    public function getConfig($app_id)
    {
        $result = [];
        $result['class'] = $this->namespace;
        foreach ($this->options as $option) {
            if (!$option->app_id && isset($result[$option->name]))
                continue;
            if ($option->app_id == $app_id || !$option->app_id) {
                $result[$option->name] = $option->getConfig($app_id);
            }
        }
        return $result;
    }

    /**
     * @throws \ReflectionException
     */
    public function getClassReflection()
    {
        return new \ReflectionClass($this->namespace);
    }

    /**
     * @return bool|ReflectionProperty[]
     * @throws \ReflectionException
     */
    public function getClassProperties()
    {
        $reflection = $this->getClassReflection();
        return $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getClassDefaultProperties()
    {
        $result = [];
        $class = $this->getClassReflection();

        foreach ($class->getDefaultProperties() as $key => $property) {
            if ($class->getProperty($key)->isPublic() && $class->getProperty($key)->getDeclaringClass()->getName() == $class->getName()) {
                $result[$key] = $property;
            }
        };
        return $result;
    }


    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getBreadcrumbs()
    {
        $result = Module::getBreadcrumbs();
        $result[] = ['label' => Module::t($this->formName()), 'url' => ['modules/index']];

        if (!$this->isNewRecord) {
            $result[] = ['label' => $this->name, 'url' => ['modules/view', 'id' => $this->id]];

        }
        return $result;
    }


}
