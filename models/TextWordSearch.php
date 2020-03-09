<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TextWord;

/**
 * TextWordSearch represents the model behind the search form of `app\models\TextWord`.
 */
class TextWordSearch extends TextWord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_text', 'id_word', 'status', 'state'], 'integer'],
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
    public function search($params, $id_text, $page_size)
    {
        $query = TextWord::find()->where(['id_text' => $id_text]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => $page_size],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            // 'id_text' => $this->id_text,
            // 'id_word' => $this->id_word,
            // 'status' => $this->status,
            'state'=> $this->state,
        ]);

        return $dataProvider;
    }
}
