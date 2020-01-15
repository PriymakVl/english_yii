<?php

namespace app\controllers;

use Yii;
use app\models\Sentense;
use app\models\SentenseSearch;
use app\models\Text;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SentenseController extends \app\controllers\BaseController
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

    public function actionIndex($id_text)
    {
        $text = Text::findOne($id_text);
        $sentenses = Sentense::findAll(['id_text' => $id_text, 'status' => 1]);
        if (!$sentenses) Sentense::breakText($text);
        $sentenses = Sentense::findAll(['id_text' => $id_text, 'status' => 1]);
        if (!$sentenses) throw new NotFoundHttpException('Предложения для текста не найдены');
        return $this->render('index', compact('sentenses', 'text'));
    }

    /**
     * Displays a single Sentense model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $direction = false)
    {
        if ($direction == 'next') $id++;
        else if ($direction == 'previos') $id--;
        $model = Sentense::findOne($id);
        if (!$model) throw new NotFoundHttpException('Предложение не найдено');
        $model->getAll()->getCurrentNumber()->getVariantsRu();
        return $this->render('view', compact('model'));
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
