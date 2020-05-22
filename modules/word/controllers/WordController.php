<?php

namespace app\modules\word\controllers;

use Yii;
use yii\helpers\Url;
use app\modules\word\models\{Word, SearchWord, WordText};
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class WordController extends \app\controllers\BaseController
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
                    // 'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Word models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params['query'] = Word::find()->where(['status' => STATUS_ACTIVE]);
        $params['pagination'] = ['pageSize' => 10];
        $dataProvider = new ActiveDataProvider($params);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Word model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Word model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Word();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Word model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset($this->session['back'])) return $this->redirect(['/text-word/after-update', 'id_word' => $id]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Word model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $word = Word::findOne($id);
        $word->remove();
        $items = WordText::findAll(['word_id' => $word->id]);
        if ($items) array_walk($items, function($item) {$item->remove();});
        return $this->setMessage('Слово удалено')->redirect(Url::previous());
    }

    public function actionSetState($id)
    {
        $word = Word::findOne($id);
        $word->setState();
        if(Yii::$app->request->isAjax){
            return 'Состояние слова изменено!';
        }
        return $this->setMessage('Состояние слова изменено')->redirect(Url::previous());
    }

    public function actionAddVoice()
    {
        $model = new Word();
        return $this->render('voice', ['model' => $model]);
    }

    /**
     * Finds the Word model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Word the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Word::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
