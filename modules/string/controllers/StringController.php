<?php

namespace app\modules\string\controllers;

use Yii;
use app\modules\string\models\{FullString, FullStringSearch, SubString};
use app\modules\text\models\{Text, SubText};
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

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
        $searchModel = new FullStringSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionText($text_id)
    {
        Url::remember();
        $searchModel = new FullStringSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $text = Text::findOne($text_id);
        $text->countStatistics($text->strings);
        return $this->render('text', compact('text', 'searchModel', 'dataProvider'));
    }

    public function actionBreakSubText($text_id)
    {
        $subtexts = SubText::findAll(['text_id' => $text_id, 'status' => STATUS_ACTIVE]);
        if (!$subtexts) return $this->setMessage("У текста еще нет абзацев")->back();
        FullString::break($subtexts);
        return $this->setMessage("Текст успешно разбит на предложения")->back();
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $substr = new SubString();
        return $this->render('view', compact('model', 'substr'));
    }

    /**
     * Creates a new FullString model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FullString();
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
        if ($model->load(Yii::$app->request->post()) && $model->edit(TYPE_STRING)) {
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
        $str = $this->findModel($id);
        $str->remove();
        return $this->redirect(['text', 'text_id' => $str->text_id]);
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
        if (($model = FullString::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
