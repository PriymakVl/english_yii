<?php

namespace app\models;

use Yii;
use app\models\Word;
use app\models\Sentense;

/**
 * This is the model class for table "sound".
 *
 * @property int $id
 * @property int $type
 * @property int $item_id
 * @property string $filename
 * @property int|null $status
 */
class Sound extends \yii\db\ActiveRecord
{

    const SCENARIO_FILE = 'file';
    const TYPE_WORD = 1;
    const TYPE_SENTENSE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sound';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'item_id', 'status'], 'integer'],
            [['filename'], 'string', 'max' => 100],
            [['filename'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'item_id' => 'Item ID',
            'filename' => 'Filename',
            'status' => 'Status',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[static::SCENARIO_FILE] = ['type'];
        return $scenarios;
    }

    public function getItemsForCreateSoundOfFile()
    {
        if ($this->type == self::TYPE_WORD) return Word::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
        return Sentense::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
    }
}
