<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "text_word".
 *
 * @property int $id
 * @property int|null $id_text
 * @property int|null $id_word
 * @property int|null $status
 */
class TextWord extends \yii\db\ActiveRecord
{
    public $file_ru;
    public $file_engl;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'text_word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_ru', 'file_engl'], 'required'],
            [['file_ru', 'file_engl'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
            $obj = new self;
            $obj->id_text = $this->id;
            $obj->engl = $words['engl'][$i];
            $obj->ru = mb_convert_encoding($words['ru'][$i], "utf-8", "windows-1251");
            $obj->save();
        }
    }

    private function getWordsFromFiles()
    {
        $file_ru = UploadedFile::getInstance($this, 'file_ru');
        $words['ru'] = file($file_ru->tempName);
        $file_engl = UploadedFile::getInstance($this, 'file_engl');
        $words['engl'] = file($file_ru->tempName);
        return $words;
    }
}
