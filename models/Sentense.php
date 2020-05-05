<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Sound;

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
    const SCENARIO_SOUND = 'sound';
    const SCENARIO_UPDATE = 'update';

    public $all; //array all of setneses text
    public $allQty; //count all sentenses of text
    public $currentNum;
    public $soundfile;

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
            [['id_text', 'status', 'sound_id'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['sound'], 'file',  'extensions' => 'wav, mp3'], //'skipOnEmpty' => false,
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

    public function scenarios()
{
    $scenarios = parent::scenarios();
    $scenarios[static::SCENARIO_SOUND] = ['sound_id'];
    $scenarios[static::SCENARIO_UPDATE] = ['id_text, status, engl, ru'];
    return $scenarios;
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
            $word = Word::findOne(['engl' => trim($item), 'status' => STATUS_ACTIVE]);
            if ($word) $words[] = $word;
        }
        return $words;
    }

    public function getPhrases()
    {
        return $this->hasMany(Phrase::className(), ['id_sentense' => 'id'])->where(['status' => STATUS_ACTIVE]);
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

    public function updateSentense()
    {
        if ($this->validate()) {
            $this->soundfile = UploadedFile::getInstance($this, 'soundfile');
            if ($this->soundfile) $this->sound_id = Sound::create(Sound::TYPE_SENTENSE, $this->soundfile->baseName, $this->soundfile->extension, $this->id);
        }
        return $this->save();
    }

    public function getSound()
    {
        return $this->hasOne(Sound::className(), ['id' => 'sound_id']);    
    }

    public static function getNeighbor($id, $direction)
    {
        $sentense = self::findOne($id);
        if (!$sentense) return false;
        $sentenses_text = self::findAll(['id_text' => $sentense->id_text, 'status' => STATUS_ACTIVE]);
        foreach ($sentenses_text as $key => $value) {
            if ($value->id == $sentense->id) {
                if ($direction == 'next' && $key == count($sentenses_text) - 1) return $sentenses_text[0];
                if ($direction == 'next') return $sentenses_text[++$key];
                if ($direction == 'prev' && $key == 0) return $sentenses_text[count($sentenses_text) - 1];
                if ($direction == 'prev') return $sentenses_text[--$key];
            }
        }
        throw new NotFoundHttpException('Не найдено предложения'); 
    }

    public function delete()
    {
        $this->status = STATUS_INACTIVE;
        $this->save(false);
        return $this;
    }


}
