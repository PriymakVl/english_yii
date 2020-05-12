<?php

namespace app\controllers;

use Yii;
use app\models\Phrase;
use app\models\Text;
use app\models\PhraseSearch;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\UploadedFile;

/**
 * PhraseController implements the CRUD actions for Phrase model.
 */
class PhraseController extends BaseController
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
     * Lists all Phrase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhraseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Phrase model.
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
     * Creates a new Phrase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateForm()
    {
        $model = new Phrase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //from sentense
    public function actionCreate()
    {
        $model = new Phrase();
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->setMessage('Фраза добавлена')->redirect(['/sentense/view', 'id' => $model->id_sentense]);
        }
        throw new NotFoundHttpException('Ошибка при добавлении фразы');
    }

    public function actionAddFromFiles($id_text = false)
    {
        $model = new Phrase(['scenario' => Phrase::SCENARIO_FILES]); 
        if (!Yii::$app->request->isPost) return $this->render('add_files', compact('model', 'id_text'));
        $model->load(Yii::$app->request->post());
        $model->file_ru = UploadedFile::getInstance($model, 'file_ru');
        $model->file_engl = UploadedFile::getInstance($model, 'file_engl');
        $model->addFromFiles();
        return $this->setMessage('Фразы добавлены')->redirect(['text', 'id_text' => $model->id_text]);
    }

    /**
     * Updates an existing Phrase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->updatePhrase()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Phrase model.
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

    public function actionText($id_text)
    {
        $text = Text::findOne($id_text);
        $query = Phrase::find()->where(['id_text' => $id_text, 'status' => STATUS_ACTIVE]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $phrases = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('text', [
            'phrases' => $phrases, 'pages' => $pages, 'text' => $text,
        ]);
    }

    public function actionSounds($id_text = false, $state = false)
    {
        $state = $state ? $state : Phrase::STATE_ALL;
        $phrases_str = Phrase::createSoundsString($state, $id_text);
        return $this->render('sounds', compact('phrases_str', 'id_text'));
    }

    public function actionRepeat($id_text)
    {
        $phrases = Phrase::findAll(['id_text' => $id_text, 'status' => STATUS_ACTIVE]);
        shuffle($phrases);
        return $this->render('repeat', compact('phrases', 'id_text'));
    }

    /**
     * Finds the Phrase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Phrase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Phrase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
