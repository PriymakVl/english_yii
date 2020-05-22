<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Text;

/**
 * TextSearch represents the model behind the search form of `app\models\Text`.
 */
class TextSearch extends Text
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'status'], 'integer'],
            [['title', 'engl', 'ru', 'ref'], 'string'],
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
    public function search($params, $pageSize)
    {
        $where = ['status' => STATUS_ACTIVE];
        if (isset($params['cat_id'])) $where = array_merge($where, ['cat_id' => $params['cat_id']]);
        $query = Text::find()->where($where);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => $pageSize,],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'status' => STATUS_ACTIVE,
        // ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
}
