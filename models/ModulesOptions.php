<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\models;

use diazoxide\yii2config\Module;
use paulzi\adjacencyList\AdjacencyListBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * @property string $id
 * @property string $name
 * @property int $parent_id
 * @property int $app_id
 * @property int $module_id
 * @property ModulesOptions parent
 * @property array breadcrumbs
 * @property Module module
 * @property array config
 * @property string value
 * @property boolean is_object
 */
class ModulesOptions extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config_modules_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'module_id'], 'required'],
            [['parent_id', 'module_id'], 'integer'],
            [['name', 'app_id'], 'string', 'max' => 255],
            [['value'], 'string'],
            [['is_object'], 'boolean'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => AdjacencyListBehavior::class,
                'sortable' => [
                    'sortAttribute' => 'sort'
                ]
            ]
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {

        $this->module->touch('updated_at');

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Modules::class, ['id' => 'module_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'name' => Module::t('Name'),
            'value' => Module::t('Value'),
            'parent_id' => Module::t('Parent'),
        ];
    }

    public function getOptions()
    {
        return $this->hasMany(ModulesOptions::class, ['parent_id' => 'id']);
    }

    public function getConfig($app_id)
    {
        $result = [];

        if (!$this->is_object) {
            $result = $this->value;
        } elseif ($this->getChildren()->count()) {
            /** @var ModulesOptions $child */
            foreach ($this->getChildren()->all() as $child) {
                if (!$child->app_id && isset($result[$child->name]))
                    continue;
                if ($child->app_id == $app_id || !$child->app_id) {
                    $result[$child->name] = $child->getConfig($app_id);
                }
            }
        } else $result = [];

        return $result;
    }

    public function getBreadcrumbs()
    {
        $result = [];
        if ($this->parent_id == null) {
            $result = $this->module->breadcrumbs;
            $result[] = ['label' => Module::t('Options'), 'url' => ['modules/options', 'id' => $this->module_id]];

        } else {
            $result = array_merge($result, $this->parent->breadcrumbs);
            $result[] = ['label' => $this->parent->name, 'url' => ['modules/option-update', 'id' => $this->parent_id]];
        }
        return $result;
    }

}
