<?php

namespace app\modules\string\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\{Sound, Text};
use app\modules\word\models\Word;

class BaseString extends \app\models\ModelApp
{
    // const DELIMITER_PUNCTUATION_MARKS = 1;
    // const DELIMITER_LINE_BREAK = 2;

    public $sound_file;

    // public function addFromFiles()
    // {
    //     if (!$this->validate()) throw new NotFoundHttpException('Validate not');
    //     $phrases['ru'] = $this->getFromFile($this->file_ru->tempName);
    //     $phrases['engl'] = $this->getFromFile($this->file_engl->tempName);
    //     for ($i = 0; $i < count($phrases['engl']); $i++) {
    //         $phrase = self::findOne(['engl' => $phrases['engl'][$i], 'id_text' => $this->id_text]);
    //         if ($phrase) continue;
    //         $this->add($phrases['engl'][$i], $phrases['ru'][$i], $this->id_text);
    //     }
    // }

    private function getFromFile($filename)
    {
        if ($this->delimeter == self::DELIMITER_PUNCTUATION_MARKS) throw new NotFoundHttpException('деление по знакам препинания не реализовано');
        return file($filename);
    }

    // public function add($engl, $ru, $text_id)
    // {
    //     $this->engl = htmlspecialchars(trim($engl));
    //     $ru = mb_convert_encoding(trim($ru), "utf-8", "windows-1251");
    //     $this->ru = htmlspecialchars($ru);
    //     $this->text_id = $text_id;
    //     return $this->save(false);
    // }

    //$type - type word, substring or string
    public function edit($type)
    {
        if ($this->validate()) {
            $this->sound_file = UploadedFile::getInstance($this, 'sound_file');
            if ($this->sound_file) {
                $sound = Sound::create($type, $this->sound_file->extension, $this->id);
                $this->sound_id = $sound->id;
            }
        }
        $this->save();
        if ($this->sound_id) $this->sound_file->saveAs('sounds/' . $sound->filename);
        return true;
    }

}
