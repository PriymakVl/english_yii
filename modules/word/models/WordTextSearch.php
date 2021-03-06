<?php

namespace app\modules\word\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class WordTextSearch extends \app\modules\word\models\WordText
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'text_id', 'word_id', 'status'], 'integer'],
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
        $where = ['status' => STATUS_ACTIVE];
        if (isset($params['text_id'])) $where['text_id'] = $params['text_id'];
        $query = WordText::find()->where($where);
        
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
        //   $query->andFilterWhere([
        // ]);

        return $dataProvider;
    }
}
