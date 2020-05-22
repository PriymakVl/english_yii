<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int|null $status
 */
class Category extends \app\models\ModelApp
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            ['parent_id', 'default', 'value' => 0],
            [['name'], 'string', 'max' => 100],
            ['status', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Родитель',
            'status' => 'Status',
        ];
    }

    // public function getMainForSelect()
    // {
    //     return self::find()->select('name')->where(['parent_id' => 0])->asArray()->indexBy('id')->column();
    // }

    public function getChildren()
    {
        return self::findAll(['parent_id' => $this->id, 'status' => STATUS_ACTIVE]);
    }

    public function getTexts()
    {
        return $this->hasMany(Text::className(), ['cat_id' => 'id'])->where(['status' => STATUS_ACTIVE]);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id'])->where(['status' => STATUS_ACTIVE]);
    }

}
