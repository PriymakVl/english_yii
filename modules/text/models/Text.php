<?php

namespace app\modules\text\models;

use Yii;
use app\modules\word\models\{WordText, Word};
use app\modules\string\models\{FullString, SubString};
use app\modules\text\models\SubText;
use app\models\Category;

/**
 * This is the model class for table "text".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property string|null $created
 * @property int|null $status
 */
class Text extends \app\models\ModelApp
{
    public $statistics;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'texts';
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

    public function getSubtexts()
    {
        return $this->hasMany(SubText::className(), ['text_id' => 'id'])->where(['status' => STATUS_ACTIVE]);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    public function getStrings()
    {
        return $this->hasMany(FullString::className(), ['text_id' => 'id'])->where(['status' => STATUS_ACTIVE]);
    }

     public function getSubstrings()
    {
        return $this->hasMany(SubString::className(), ['text_id' => 'id'])->where(['status' => STATUS_ACTIVE]);
    }

    public function getWords()
    {
        $ids = WordText::find()->select('word_id')->where(['text_id' => $this->id, 'status' => STATUS_ACTIVE])->asArray()->column();
        return Word::find()->where(['id' => $ids, 'status' => STATUS_ACTIVE])->all();
    }

    public function sortItems($items, $state)
    {
        if (!$items) return;
        $sort = array_filter($items, function($item) {return $item->state == $state;});
        if ($sort) return array_values($sort);
    }

    public function countStatistics($items)
    {
        if (!$items) return;
        $this->statistics = ['all' => count($items), 'learned' => 0, 'not_learned' => 0];
        foreach ($items as $item) {
            if ($item->state == STATE_LEARNED) $this->statistics['learned']++;
            else $this->statistics['not_learned']++;        }
        return $this;
    }
}
