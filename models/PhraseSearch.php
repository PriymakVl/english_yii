<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Phrase;

/**
 * PhraseSearch represents the model behind the search form of `app\models\Phrase`.
 */
class PhraseSearch extends Phrase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_text', 'id_sentense', 'status'], 'integer'],
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
        $query = Phrase::find();

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
            'id_text' => $this->id_text,
            'id_sentense' => $this->id_sentense,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'engl', $this->engl])
            ->andFilterWhere(['like', 'ru', $this->ru]);

        return $dataProvider;
    }
}