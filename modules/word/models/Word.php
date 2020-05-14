<?php

namespace app\modules\word\models;

use Yii;
use app\models\Sound;

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
    // const SCENARIO_STATE = 'state';
    // const SCENARIO_DELETE = 'delete';

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
        // $scenarios[static::SCENARIO_STATE] = ['state'];
        // $scenarios[static::SCENARIO_DELETE] = ['status'];
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
            'saund' => 'Saund'
        ];
    }

    public static function getSoundsString($state)
    {
        if ($state == STATE_ALL) $words = self::findAll(['status' => STATUS_ACTIVE]);
        else {
            $ids = State::find()->select('item_id')->where(['state' => $state, 'status' => STATUS_ACTIVE, 'user_id' => Yii::$app->user->id, 'type' => TYPE_WORD])->asArray()->all();
            $words = self::findAll($ids);
        }
        return self::createSoundsString($words);
    }
}
