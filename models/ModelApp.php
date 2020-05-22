<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\{Sound, State};
use yii\web\NotFoundHttpException;

class ModelApp extends \yii\db\ActiveRecord
{

    public function remove()
    {
        $this->status = STATUS_INACTIVE;
        if (!$this->save(false)) throw new NotFoundHttpException('error remove item class ModelBase.php');
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

}
