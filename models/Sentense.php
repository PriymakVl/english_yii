<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "sentense".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property int|null $id_text
 * @property int|null $status
 */
class Sentense extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sentense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_text', 'status'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
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
            'id_text' => 'Id Text',
            'status' => 'Status',
        ];
    }

    public static function breakText($text)
    {
        $count_engl_str = preg_match_all("/.*?[.?!](?:\s|$)/s", $text->engl, $engl_str);
        $count_ru_str = preg_match_all("/.*?[.?!](?:\s|$)/s", $text->ru, $ru_str);
        if (!$count_engl_str || !$count_ru_str) return;
        return self::addFromText($engl_str[0], $ru_str[0], $text->id);
    }

    public static function addFromText($engl_str, $ru_str, $id_text)
    {
        for ($i = 0; $i < count($engl_str); $i++) {
            $obj = new self;
            $obj->engl = $engl_str[$i];
            $obj->ru = $ru_str[$i];
            $obj->id_text = $id_text;
            $obj->save();
        }
    }
}
