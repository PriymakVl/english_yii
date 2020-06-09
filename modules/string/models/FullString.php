<?php

namespace app\modules\string\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Sound;
use app\modules\string\models\SubString;

/**
 * This is the model class for table "strings".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property int|null $id_text
 * @property int|null $status
 */
class FullString extends \app\modules\string\models\BaseString
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'strings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_id', 'status', 'sound_id'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['engl', 'ru'], 'required'],
            [['sound_file'], 'file',  'extensions' => 'wav, mp3'],
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
            'text_id' => 'Id Text',
            'status' => 'Status',
        ];
    }

    // private function getRandom()
    // {
    //     $num = rand(1, $this->allQty);
    //     if ($num == $currentNum) $this->getRandom();
    //     return $this->all[$num - 1];
    // }

    public function getSubstrings()
    {
        return $this->hasMany(SubString::className(), ['str_id' => 'id'])->where(['status' => STATUS_ACTIVE]);
    }

    public function shiftUpLanguage($lang)
    {
        $sentenses = self::findAll(['id_text' => $this->id_text, 'status' => STATUS_ACTIVE]);
        for ($i = 0, $count = count($sentenses); $i < $count; $i++) {
            if ($sentenses[$i]->id == $this->id) $sentenses_shift = array_slice($sentenses, $i);
        }
        $this->shiftUp($lang, $sentenses_shift);
    }

    private static function shiftUp($lang, $sentenses)
    {
        for ($i = 0, $count = count($sentenses); $i < $count; $i++) {
            $key = $i + 1;
            if ($i == $count - 1) $sentenses[$i]->status = STATUS_INACTIVE;
            else {
                if ($lang == 'engl') $sentenses[$i]->engl = $sentenses[$key]->engl;
                else $sentenses[$i]->ru = $sentenses[$key]->ru;
            }
            $sentenses[$i]->save(false);
        }
    } 

    public static function add($engl, $ru, $text_id, $subtext_id)
    {
            $obj = new self;
            //delete line break
            $engl = str_replace("\r\n", "", $engl);
            $ru = str_replace("\r\n", "", $ru);
            $obj->engl = trim($engl);
            $obj->ru = trim($ru);
            $obj->text_id = $text_id;
            $obj->subtext_id = $subtext_id;
            $obj->save();
    }
    //breal subtext on string 
    public static function break($subtexts)
    {
        foreach ($subtexts as $sub) {
            preg_match_all("/.*?[.?!](?:\s|$)/s", $sub->engl, $engl_str);
            preg_match_all("/.*?[.?!](?:\s|$)/s", $sub->ru, $ru_str);
            self::addStrings($engl_str[0], $ru_str[0], $sub->text->id, $sub->id);
        }
    } 

    private static function addStrings($engl_str, $ru_str, $text_id, $subtext_id)
    {
        for ($i = 0, $count = count($engl_str); $i < $count; $i++) {
            $check = self::findOne(['engl' => $engl_str[$i], 'subtext_id' => $subtext_id]);
            if ($check) continue;
            self::add($engl_str[$i], $ru_str[$i], $text_id, $subtext_id);
        }
    }

}
