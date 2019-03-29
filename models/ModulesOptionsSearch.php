<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\yii2config\models;

use diazoxide\yii2config\models\ModulesOptions;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BlogCategorySearch represents the model behind the search form about `diazoxide\blog\models\BlogCategory`.
 */
class ModulesOptionsSearch extends ModulesOptions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'module_id'], 'integer'],
            [['is_object'], 'boolean'],
            [['name', 'value','app_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ModulesOptions::find();

        $query->orderBy(['sort' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'module_id' => $this->module_id,
            'parent_id' => $this->parent_id,
            'value' => $this->value,
            'sort' => $this->sort
        ]);

        return $dataProvider;
    }
}
