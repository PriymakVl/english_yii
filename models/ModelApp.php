<?php

namespace app\models;

use Yii;
use app\models\Sound;
use yii\web\NotFoundHttpException;

class ModelApp extends \yii\db\ActiveRecord
{
    public function remove()
    {
        $this->status = STATUS_INACTIVE;
        if (!$this->save(false)) throw new NotFoundHttpException('error remove item class ModelBase.php');
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        if (!$this->save(false)) throw new NotFoundHttpException('error set state item class ModelBase.php');
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
}
