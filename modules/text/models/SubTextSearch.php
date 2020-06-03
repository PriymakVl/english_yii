<?php

namespace app\modules\text\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\text\models\SubText;

/**
 * SubTextSearch represents the model behind the search form of `app\modules\text\models\SubText`.
 */
class SubTextSearch extends SubText
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'text_id', 'state', 'status'], 'integer'],
            [['engl', 'ru'], 'safe'],
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
        $query = SubText::find();

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
            'text_id' => $this->text_id,
            'state' => $this->state,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'engl', $this->engl])
            ->andFilterWhere(['like', 'ru', $this->ru]);

        return $dataProvider;
    }
}
