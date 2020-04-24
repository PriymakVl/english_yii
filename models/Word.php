<?php

namespace app\models;

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
    const SCENARIO_STATE = 'state';
    const SCENARIO_DELETE = 'delete';

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
            [['status', 'state'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['engl'], 'unique'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_STATE] = ['state'];
        $scenarios[static::SCENARIO_DELETE] = ['status'];
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

    public function setState($state)
    {
        $this->scenario = self::SCENARIO_STATE;
        $this->state = $state;
        return $this->save();
    }

    public function getSound()
    {
        return $this->hasOne(Sound::className(), ['id' => 'sound_id']);
    }

    public static function createSoundsString($state, $id_text = false)
    {
        if ($id_text) {
            $ids = TextWord::find()->select('id_word')->where(['id_text' => $id_text, 'status' => STATUS_ACTIVE, 'state' => $state])->column();

            // debug($ids);
            $words = $ids ? self::findAll($ids) : false;
        }
        else $words = self::findAll(['status' => STATUS_ACTIVE, 'state' => $state]);
        if (!$words) return false;
        $words_str = '';
        foreach ($words as $word) {
            if (!$word->sound_id) continue;
            $words_str .= $word->sound->filename.':'.$word->engl.':'.$word->ru.':'.$word->id.',';
        }
        return $words_str;
    }
}
