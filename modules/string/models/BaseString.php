<?php

namespace app\modules\string\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\{Sound, Text};

class BaseString extends \app\models\ModelApp
{
    const DELIMITER_PUNCTUATION_MARKS = 1;
    const DELIMITER_LINE_BREAK = 2;

    const SCENARIO_FILES = 'files';

    // public static function createSoundsString($state, $id_text = false)
    // {
    //     $where = ['status' => STATUS_ACTIVE];
    //     $where = ($state == self::STATE_ALL) ?  $where : array_merge($where, ['state' => $state]);
    //     $where = $id_text ? array_merge($where, ['id_text' => $id_text]) : $where;
    //     $phrases = self::findAll($where);
    //     if (!$phrases) return false;
    //     $phrases_str = '';
    //     foreach ($phrases as $phrase) {
    //         if (!$phrase->sound_id) continue;
    //         $phrases_str .= $phrase->sound->filename.':'.$phrase->engl.':'.$phrase->ru.':'.$phrase->id.';';
    //     }
    //     return $phrases_str;
    // }

    public function addFromFiles()
    {
        if (!$this->validate()) throw new NotFoundHttpException('Validate not');
        $phrases['ru'] = $this->getFromFile($this->file_ru->tempName);
        $phrases['engl'] = $this->getFromFile($this->file_engl->tempName);
        for ($i = 0; $i < count($phrases['engl']); $i++) {
            $phrase = self::findOne(['engl' => $phrases['engl'][$i], 'id_text' => $this->id_text]);
            if ($phrase) continue;
            $this->add($phrases['engl'][$i], $phrases['ru'][$i], $this->id_text);
        }
    }

    private function getFromFile($filename)
    {
        if ($this->delimeter == self::DELIMITER_PUNCTUATION_MARKS) throw new NotFoundHttpException('деление по знакам препинания не реализовано');
        return file($filename);
        // array_walk($phrases, str_replace('', ''', subject))
    }

    private function add($engl, $ru, $id_text)
    {
        $obj = new self;
        $obj->engl = htmlspecialchars($engl);
        $ru = mb_convert_encoding($ru, "utf-8", "windows-1251");
        $obj->ru = htmlspecialchars($ru);
        $obj->id_text = $id_text;
        $obj->save(false);
    }

    public function getText()
    {
        return $this->hasOne(Text::className(), ['id' => 'text_id']);
    }

}
