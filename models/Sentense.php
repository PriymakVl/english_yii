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

    public $all; //array all of setneses text
    public $allQty; //count all sentenses of text
    public $currentNum;

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
            $engl = str_replace("\r\n", " ", $engl_str[$i]);//delete line break
            $ru = str_replace("\r\n", " ", $ru_str[$i]);
            $obj->engl = trim($engl);
            $obj->ru = trim($ru);
            $obj->id_text = $id_text;
            $obj->save();
        }
    }

    public function getAll()
    {
         $this->all = Sentense::findAll(['id_text' => $this->id_text, 'status' => 1]);
         $this->allQty = count($this->all);
         return $this;
    }

    public function getCurrentNumber()
    {
        $this->currentNum = 1;
        foreach ($this->all as $item) {
            if ($item->id == $this->id) return $this;
            $this->currentNum++;
        }
        return $this;
    }

    public function getVariantsRu($count = 2)
    {
        $this->variantsRu[$this->id] = $this->ru; 
        for ($i = 1; $i < $count; $i++) {
            $item = $this->getRandom();
            $this->variantsRu[$item->id] = $item->ru;
        }
        shuffle($this->variantsRu);
    }

    private function getRandom()
    {
        $num = rand(1, $this->allQty);
        if ($num == $currentNum) $this->getRandom();
        return $this->all[$num - 1];
    }

    public function getWords()
    {
        $items = explode(' ', $this->engl);
        $words = [];
        foreach ($items as $item) {
            $word = Word::findOne(['engl' => trim($item), 'status' => 1]);
            if ($word) $words[] = $word;
        }
        return $words;
    }

    //shift by one row in text array
    public static function align($text_id, $lang)
    {
        $sentenses = self::findAll(['id_text' => $text_id, 'status' => STATUS_ACTIVE]);
        $empty = false;
        for ($i = 0, $count = count($sentenses); $i < $count; $i++) {
            if ($empty) {
                self::shiftSentense($i, $sentenses, $lang);
                continue;
            }
            if (empty($sentenses[$i]->ru) || empty($sentenses[$i]->engl))  $empty = true;
        }
    }

    private static function shiftSentense($index, $sentenses, $lang)
    {
        $obj_empty = $sentenses[$index - 1];
        $obj_source = $sentenses[$index];
        if ($lang = 'ru') $obj_empty->ru = $obj_source->ru;
        if ($lang = 'engl') $obj_empty->engl = $obj_source->engl;
        $obj_empty->save();
    } 
}
