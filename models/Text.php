<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property string|null $created
 * @property int|null $status
 */
class Text extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            [['engl', 'ru', 'title'], 'string'],
            [['created'], 'safe'],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Заголовок',
            'engl' => 'Английский',
            'ru' => 'Русский',
            'created' => 'Добавлен',
            'status' => 'Status',
        ];
    }
}
