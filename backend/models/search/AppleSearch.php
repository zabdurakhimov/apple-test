<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Apple;

/**
 * RegionSearch represents the model behind the search form of `backend\models\Apple`.
 */
class AppleSearch extends Apple
{
    public $active;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['color', 'fallen_at', 'created_at', 'deleted_at', 'active'], 'safe'],
            [['size'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Apple::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'size' => $this->size,
            'fallen_at' => $this->fallen_at,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ]);

        if ($this->active) {
            $query->andWhere(['deleted_at' => null]);
        } else {
            $query->andWhere(['not', ['deleted_at' => null]]);
        }

        $query->andFilterWhere(['like', 'color', $this->color]);

        return $dataProvider;
    }
}
