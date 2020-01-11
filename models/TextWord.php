<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\Word;
use app\models\Sentense;

class TextWord extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_DELETE = 'delete';
    const SCENARIO_STATE = 'state';
    const STATE_NOT_LEARNED = 0;
    const STATE_LEARNED = 1;

    public $file_ru;
    public $file_engl;
    public $ru;
    public $engl;
    public $sentenses;

    public static function tableName()
    {
        return 'text_word';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_CREATE] = ['file_ru', 'file_engl'];
        $scenarios[static::SCENARIO_DELETE] = ['status'];
        $scenarios[static::SCENARIO_STATE] = ['state'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['file_ru', 'file_engl'], 'required'],
            [['file_ru', 'file_engl'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_text' => 'Id Text',
            'id_word' => 'Id Word',
            'status' => 'Status',
        ];
    }

    public function saveWords()
    {
        $words = $this->getWordsFromFiles();
        for ($i = 0; $i < count($words['engl']); $i++) {
            $word = Word::findOne(['engl' => $words['engl'][$i], 'status' => 1]);
            if (!$word) $word = $this->addWord($words, $i);
            $sql = sprintf("INSERT INTO `%s` (`id_text`, `id_word`) VALUES (%d, %d)", $this->tableName(), $this->id_text, $word->id);
            \Yii::$app->db->createCommand($sql)->execute();
        }
        return true;
    }

    private function getWordsFromFiles()
    {
        $file_ru = UploadedFile::getInstance($this, 'file_ru');
        $words['ru'] = file($file_ru->tempName);
        $file_engl = UploadedFile::getInstance($this, 'file_engl');
        $words['engl'] = file($file_engl->tempName);
        return $words;
    }

    private function addWord($words, $i) {
        $word = new Word;
        $word->engl = strtolower(trim($words['engl'][$i]));
        //ru
        $ru = mb_convert_encoding($ru, "utf-8", "windows-1251");
        $word->ru = mb_strtolower(trim($words['ru'][$i]));

        $res = $word->save();
        return Word::findOne(['engl' => trim($words['engl'][$i])]);
    }

    public function getSentenses()
    {
        $word = Word::findOne($this->id_word);
        if (!$word) return false;
        return Sentense::find()->where(['like', 'engl', $word->engl])->all();
    }

    public function getWord()
    {
        return $this->hasOne(Word::className(), ['id' => 'id_word']);
    }

    public static function getByIndex($id_text, $index, $learned = true)
    {
        $params = ['id_text' => $id_text, 'status' => STATUS_ACTIVE, 'state' => self::STATE_NOT_LEARNED];
        if (!$learned) unset($params['state']);
        $items = TextWord::findAll($params);
        $index = isset($items[$index]) ? $index : 0;
        return $items[$index];
    }

    public function setState($state)
    {
        $this->scenario = self::SCENARIO_STATE;
        $this->state = $state;
        return $this->save();
    }

}
