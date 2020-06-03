<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\{Sound, State};
use yii\web\NotFoundHttpException;
use app\modules\string\models\{FullString, SubString};
use app\modules\word\models\{Word, WordText};
use app\modules\text\models\{Text, SubText};

class ModelApp extends \yii\db\ActiveRecord
{

    public function remove()
    {
        $this->status = STATUS_INACTIVE;
        if (!$this->save(false)) throw new NotFoundHttpException('error remove item class app\modelsModelApp');
        return $this;
    }

    public function getSound()
    {
        return $this->hasOne(Sound::className(), ['id' => 'sound_id']);
    }

    //for sounds in js file
    public static function createSoundsString($objects)
    {
        $sounds_str = '';
        foreach ($objects as $obj) {
            if (!$obj->sound_id) continue;
            $sounds_str .= $obj->sound->filename.':'.$obj->engl.':'.$obj->ru.':'.$obj->id.';';
        }
        return $sounds_str;
    }

    public function getText()
    {
        return $this->hasOne(Text::className(), ['id' => 'text_id']);
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

    public function getState()
    {   
        return State::get($this);
    }

    public function setState()
    {
        State::set($this);
    }

    public function getClassName()
    {
        $path = get_called_class();
        $pos_end_delimeter = strrpos($path, '\\');
        return substr($path, $pos_end_delimeter + 1);
    }

    protected function getStringsFromFile($filename)
    {
        $file = UploadedFile::getInstance($this, $filename);
        return file($file->tempName);
    }

    public function getNextItemId($text_id = false)
    {
        $query = $this->getQueryObject();
        if ($text_id) $ids = $query->select('id')->where(['text_id' => $text_id, 'status' => STATUS_ACTIVE])->asArray()->column();
        else $ids = $query->select('id')->where(['status' => STATUS_ACTIVE])->asArray()->column();
        $index = array_search($this->id, $ids);
        if ($index == array_key_last($ids)) return $ids[0];
        return $ids[$index + 1];
    }

    public function getPrevItemId($text_id = false)
    {
        $query = $this->getQueryObject();
        if ($text_id) $ids = $query->select('id')->where(['text_id' => $text_id, 'status' => STATUS_ACTIVE])->asArray()->column();
        else $ids = $query->select('id')->where(['status' => STATUS_ACTIVE])->asArray()->column();
        $index = array_search($this->id, $ids);
        if ($index == 0) return $ids[array_key_last($ids)];
        return $ids[$index - 1];
    }

    protected function getQueryObject()
    {
        $classname = $this->getClassName();
        switch ($classname) {
            case 'FullString': return FullString::find();
            case 'SubString': return SubString::find();
            case 'Word': return Word::find();
            case 'WordText': return WordText::find();
            default: return null;
        }
    }

    public function getSoundPlayer()
    {
        if (!$this->sound) return '<span class="red">нет</span>';
        return sprintf('<i class="fas fa-play-circle player-btn" onclick="sound_play(this);" sound="%s"></i>', $this->sound->filename);
    }

}
