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
            $file = $model->createFile();
        }
        
    }

    public function actionAddFile()
    {
        return $this->render('add-file');
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
