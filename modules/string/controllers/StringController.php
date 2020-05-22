<?php

namespace app\modules\string\controllers;

use Yii;
use app\modules\string\models\{FullString, FullStringSearch, SubString};
use app\models\Text;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class StringController extends \app\controllers\BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

    }

    public function actionText($text_id)
    {
        $text = Text::findOne($text_id);
        $strings = FullString::findAll(['text_id' => $text_id, 'status' => STATUS_ACTIVE]);
        return $this->render('text', compact('strings', 'text'));
    }

    public function actionBreakText($text_id)
    {
        debug($text_id);
        // if (!$) Sentense::breakText($text);
    }

    /**
     * Displays a single Sentense model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $direction = false)
    {
        if ($direction) $model = Sentense::getNeighbor($id, $direction);
        else $model = Sentense::findOne($id);
        if (!$model) throw new NotFoundHttpException('Предложение не найдено');
        $phrase = new Phrase();
        return $this->render('view', compact('model', 'phrase'));
    }

    /**
     * Creates a new Sentense model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sentense();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sentense model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->updateSentense()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sentense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $sentense = $this->findModel($id);
        $sentense->delete();
        return $this->setMessage("Предложение успешно удалено")->redirect(['text', 'id_text' => $sentense->id_text]);
    }

    public function actionShift($id, $lang)
    {
        $sentense = Sentense::findOne($id);
        $sentense->shiftUpLanguage($lang);
        return $this->redirect(['view', 'id' => $sentense->id]);
    }

    /**
     * Finds the Sentense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sentense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sentense::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
