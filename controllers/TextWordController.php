<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\TextWordSearch;
use app\models\TextWord;
use app\models\Text;
use app\models\Word;


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

    public function actionUpdate($id, $page, $per_page)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) $this->redirectAfterUpdate($model);
        return $this->render('update', ['model' => $model,]);
    }

    private function redirectAfterUpdate($model)
    {
        $page = Yii::$app->session->get('page');
        $per_page = Yii::$app->session->get('per_page');
        $params = ['view', 'id' => $model->id, 'page' => $page, 'per_page' => $page];
        if ($perpage) return $this->redirect();
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDeleteIndex($id, $page, $perpage)
    {
        $item = $this->delete($id);
        return $this->redirect(['index', 'id_text' => $obj->id_text, 'page' => $page, 'perpage' => $perpage]);
    }

    public function actionDeleteView($id)
    {
        $item = $this->delete($id);
        return $this->redirect(['view', 'id' => $item->id_text]);
    }

    private function delete($id)
    {
        $item = TextWord::findOne($id);
        $item->scenario = TextWord::SCENARIO_DELETE;
        $item->status = 0;
        $item->save();
        return $item;
    }

    public function actionGuess($id_text)
    {
        $text = Text::findOne($id_text);
        $query = TextWord::find()->where(['id_text' => $id_text, 'status' => STATUS_ACTIVE]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);
        $words = $query->offset($pages->offset)->limit($pages->limit)->all();
        $engl = $words; $ru = $words; shuffle($ru);
        return $this->render('guess', compact('engl', 'ru', 'pages', 'text'));
    }

    public function actionWrite($id_text, $index = 0)
    {
        $text = Text::findOne($id_text);
        $item = TextWord::getByIndex($id_text, $index);
        return $this->render('write', compact('text', 'item', 'index'));
    }

    public function actionTeach($id_text, $index = 0)
    {
        $text = Text::findOne($id_text);
        $item = TextWord::getByIndex($id_text, $index);
        return $this->render('teach', compact('text', 'item', 'index'));
    }

    public function actionStateIndex($id, $state, $page, $per_page)
    {
        $item = TextWord::findOne($id);
        $this->setState($item, $state);
        $this->redirect(['index', 'id_text' => $item->id_text, 'page' => $page, 'per-page' => $per_page]);
    }

    public function actionStateTeach($id, $index)
    {
        $item = TextWord::findOne($id);
        $this->setState($item, TextWord::STATE_LEARNED);
        $this->redirect(['teach', 'id_text' => $id_text, 'index' => $index]);
    }

    private function setState($item, $state)
    {
        $item->setState($state);
        $word = Word::findOne($item->id_word);
        $word->setState($state);
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
