<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text_word".
 *
 * @property int $id
 * @property int|null $id_text
 * @property int|null $id_word
 * @property int|null $status
 */
class TextWord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'text_word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_text', 'id_word', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_text' => 'Id Text',
            'id_word' => 'Id Word',
            'status' => 'Status',
        ];
    }
}
