<?php

namespace app\controllers;

use Yii;
use app\models\TextWord;
use app\models\TextWordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

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

    public function actionIndex($id_text)
    {
        $query = TextWord::find()->where(['id_text' => $id_text, 'status' => STATUS_ACTIVE]);
        $searchModel = new TextWordSearch();
        $params['query'] = $query;
        $params['pagination'] = ['pageSize' => 8];
        $dataProvider = new ActiveDataProvider($params);
        return $this->render('index', compact('searchModel', 'dataProvider', 'id_text'));
    }

    public function actionView($id, $direction = false)
    {
        return $this->render('view', ['model' => $this->findModel($id, $direction)]);
    }

    public function actionCreate($id_text)
    {
        $model = new TextWord(['scenario' => TextWord::SCENARIO_CREATE]);
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

    public function actionGuess($id_text)
    {
        $text = Text::findOne($id_text);
        $query = TextWord::find()->where(['id_text' => $id_txt, 'status' => STATUS_ACTIVE]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 8]);
        $words = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('guess', compact('words', 'pages', 'text'));
    }

    public function actionDelete($id)
    {
        $obj = TextWord::findOne($id);
        $obj->scenario = TextWord::SCENARIO_DELETE;
        $obj->status = 0;
        $obj->save();
        return $this->redirect(['index', 'id_text' => $obj->id_text]);
    }

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
