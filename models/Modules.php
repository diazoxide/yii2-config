<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\models;


use diazoxide\yii2config\components\validators\NamespaceValidator;
use diazoxide\yii2config\Module;
use paulzi\jsonBehavior\JsonBehavior;
use paulzi\jsonBehavior\JsonValidator;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use ReflectionProperty;
use yii\base\Exception;

/**
 * @property string $id
 * @property string $name
 * @property string $namespace
 * @property boolean $status
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

    private $_status;

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
            [['name', 'namespace'], 'string', 'max' => 255],
            [['namespace'], NamespaceValidator::class],
            [['status'], 'boolean'],
            [['config'], JsonValidator::class],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => JsonBehavior::class,
                'attributes' => ['config'],
            ],
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
            'config' => Module::t('Config'),
        ];
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
        if (!$this->namespace)
            return null;
        $class = new \ReflectionClass($this->namespace);
        return $class->getDefaultProperties();
    }

    /**
     * @throws \ReflectionException
     */
    public function getProperties()
    {
        $values = $this->getClassDefaultProperties();
        $result = [];
        foreach ($this->getClassProperties() as $property) {
            $name = $property->getName();
            $value = $values[$name];
            $type = gettype($value);
            $result[] = [
                'name' => $name,
                'value' => $value,
                'type' => $type
            ];
        }
        return $result;
    }
}
