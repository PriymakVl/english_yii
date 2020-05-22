<?php

namespace app\modules\word\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use app\modules\word\models\Word;
use app\modules\string\models\FullString;

class WordText extends \app\modules\word\models\BaseWord
{
    const SCENARIO_ADD_FILES = 'files';

    public static function tableName()
    {
        return 'words_text';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_ADD_FILES] = ['file_ru', 'file_engl', 'text_id'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['file_ru', 'file_engl'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
            [['status', 'text_id'], 'integer'],
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

    public function addFromFiles($text_id)
    {
        $words['ru'] = $this->getStringsFromFile('file_ru');
        $words['engl'] = $this->getStringsFromFile('file_engl');

        for ($i = 0, $count = count($words['engl']); $i < $count; $i++) {
            $word_id = Word::getIdByName($words['engl'][$i], $words['ru'][$i]);
            if ($word_id === false) continue;
            self::add($word_id, $text_id);
        }
        return true;
    }

    private static function add($word_id, $text_id) {
        $item = new self;
        $item->word_id = $word_id;
        $item->text_id = $text_id;
        if(!$item->save(false)) throw new NotFoundHttpException('error add class WordText.');
    }

    public function getWord()
    {
        return $this->hasOne(Word::className(), ['id' => 'word_id']);
    }
}
