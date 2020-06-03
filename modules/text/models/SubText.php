<?php

namespace app\modules\text\models;

use Yii;

/**
 * This is the model class for table "sub_texts".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property int $text_id
 * @property int|null $state
 * @property int|null $status
 */
class SubText extends \app\models\ModelApp
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_texts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['engl', 'ru'], 'string'],
            [['text_id'], 'required'],
            [['text_id', 'state', 'status'], 'integer'],
        ];
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
            'text_id' => 'Text ID',
            'state' => 'State',
            'status' => 'Status',
        ];
    }

    public function getNumber()
    {
        $paragraphs = self::find()->select('id')->where(['text_id' => $this->text_id, 'status' => STATUS_ACTIVE])->asArray()->column();
        foreach ($paragraphs as $key => $value) {
            if ($value == $this->id) return $key + 1;
        }
    }

}
