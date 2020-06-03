<?php

namespace app\controllers;

use Yii;
use app\models\Sound;

class SoundController extends \app\controllers\BaseController
{
    public function actionCreateFileStrings($type, $text_id = false)
    {
        $items = Sound::getItemsForCreateSoundOfFile($type, $text_id);
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
            if ($item->engl == 'con') continue; //не озвучивает программа
            echo trim($item->engl), "\r\n", "\r\n", "\r\n";
        }
    }

    public function actionAddSounds($type)
    {
        Sound::addList($type);
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
