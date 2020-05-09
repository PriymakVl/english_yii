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
            [['title', 'cat_id'], 'required'],
            [['engl', 'ru', 'title', 'ref'], 'string'],
            [['created'], 'safe'],
            [['status', 'cat_id'], 'integer'],
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
            'cat_id' => 'Категория',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    public function getSentenses()
    {
        return $this->hasMany(Sentense::className(), ['text_id' => 'id'])->where(['status' => STATUS_ACTIVE]);
    }
}
