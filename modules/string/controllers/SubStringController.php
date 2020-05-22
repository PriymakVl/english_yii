<?php

namespace app\modules\string\controllers;

use Yii;
use app\modules\string\models\{SubString, SubStringSearch};
use app\models\Text;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * PhraseController implements the CRUD actions for Phrase model.
 */
class SubStringController extends \app\controllers\BaseController
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
        $searchModel = new SubstringSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->edit()) {
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

    public function actionText($text_id)
    {
        Url::remember();
        $searchModel = new SubstringSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;
        $text = Text::findOne($text_id);
        // $text->countStatistics($text->substrings);
        return $this->render('text', compact('text', 'searchModel', 'dataProvider'));
    }

    public function actionSounds($text_id)
    {
        $text = Text::findOne($text_id);
        $sounds_str = $text->createSoundsString($text->substrings);
        return $this->render('sounds', compact('sounds_str', 'text'));
    }

    public function actionRepeat($text_id)
    {
        $text = Text::findOne($text_id);
        $substrings = $text->substrings;
        if ($substrings) shuffle($substrings);
        return $this->render('repeat', compact('substrings', 'text'));
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
        if (($model = SubString::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
