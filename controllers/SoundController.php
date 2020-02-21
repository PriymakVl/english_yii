<?php

namespace app\controllers;

use Yii;
use app\models\Sound;

class SoundController extends \app\controllers\BaseController
{
    public function actionCreateFile($type, $text_id = false)
    {
        $model = new Sound(['scenario' => Sound::SCENARIO_FILE]);
        $model->file = 'tes';
        $model->save();
        debug($model->id);
        $items = $model->getItemsForCreateSoundOfFile($type, $text_id);
        if (!$items) return $this->setMessage('Нет элементов', 'error')->back();
        $this->giveFileToDownload($items);
    }

    private function giveFileToDownload($items) 
    {
        if (!$items) exit('нет ничего для озвучки');
        header('HTTP/1.1 200 OK');
        header("Content-Description: file transfer");
        header("Content-transfer-encoding: binary");
        header('Content-Disposition: attachment; filename="for_sounds.txt"');
         
        foreach ($items as $item) {
            echo trim($item->engl), PHP_EOL, PHP_EOL, PHP_EOL;
        }
    }

    public function actionAddSounds($type)
    {
        $model = new Sound(['scenario' => Sound::SCENARIO_FILE]);
        $model->addList($type);
        $this->setMessage('Звуковые файлы добавлены')->back();
    }

    public function actionAddSentense()
    {
        return $this->render('add-sentense');
    }

    public function actionAddWord()
    {
        return $this->render('add-word');
    }

    

}
