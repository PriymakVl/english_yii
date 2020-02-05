<?php

namespace app\controllers;

use Yii;
use app\models\Sound;

class SoundController extends \app\controllers\BaseController
{
    public function actionCreateFile()
    {
        $model = new Sound(['scenario' => Sound::SCENARIO_FILE]);
        if (!Yii::$app->request->isPost) return $this->render('create-file', ['model' => $model]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $items = $model->getItemsForCreateSoundOfFile();
            $this->giveFileToDownload($items);
        }
        
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

    public function actionAddSounds()
    {
        debug();
        $model = new Sound(['scenario' => Sound::SCENARIO_FILE]);
        if (!Yii::$app->request->isPost) return $this->render('add-sounds', ['model' => $model]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->addList();
            $this->setMessage('Звуковые файлы добавлены')->redirect('index');
        }
        return $this->render('add-sounds');
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
