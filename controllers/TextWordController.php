<?php

namespace app\controllers;

use Yii;
use app\models\TextWord;
use app\models\TextWordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TextWordController implements the CRUD actions for TextWord model.
 */
class TextWordController extends Controller
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

    /**
     * Lists all TextWord models.
     * @return mixed
     */
    public function actionIndex($id_text)
    {
        // $words = TextWord::findAll(['id_text' => $id_text, 'status' => 1]);
        $searchModel = new TextWordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', compact('searchModel', 'dataProvider', 'id_text'));
    }

    public function actionView($id, $direction = false)
    {
        return $this->render('view', ['model' => $this->findModel($id, $direction)]);
    }

    public function actionCreate($id_text)
    {
        $model = new TextWord();
        $model->id_text = $id_text;

        if (Yii::$app->request->isPost) {
            if ($model->saveWords()) {
                return $this->redirect(['index', 'id_text' => $id_text]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

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
     * Deletes an existing TextWord model.
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
     * Finds the TextWord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TextWord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $direction)
    {
        if ($direction == 'next') $id++;
        else if ($direction == 'previos') $id--;
        
        if (($model = TextWord::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
