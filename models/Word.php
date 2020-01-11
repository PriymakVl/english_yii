<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "word".
 *
 * @property int $id
 * @property string $engl
 * @property string $ru
 * @property int|null $status
 */
class Word extends \yii\db\ActiveRecord
{
    const SCENARIO_STATE = 'state';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['engl', 'ru'], 'required'],
            [['status'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['engl'], 'unique'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_STATE] = ['state'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'engl' => 'Engl',
            'ru' => 'Ru',
            'status' => 'Status',
        ];
    }

    public function setState($state)
    {
        $this->scenario = self::SCENARIO_STATE;
        $this->state = $state;
        return $this->save();
    }
}
