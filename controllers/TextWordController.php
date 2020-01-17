<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\TextWordSearch;
use app\models\TextWord;
use app\models\Text;
use app\models\Word;
use app\models\Sentense;


class TextWordController extends \app\controllers\BaseController
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

    public function actionBeforeUpdate($id, $page = false)
    {
        $item = TextWord::findOne($id);
        $this->session->set('id', $id);
        $this->session->set('page', $page);
        $this->session->set('back', $page ? 'index' : 'view');
        return $this->redirect(['/word/update', 'id' => $item->id_word]);
    }

    public function actionAfterUpdate()
    {
        $item = TextWord::findOne($this->session['id']);
        $back = $this->session['back'];
        $page = $this->session['page'];
        unset($this->session['id'], $this->session['page'], $this->session['back']);
        $this->setMessage('Слово успешно отредактировано');
        if ($back == 'index') return $this->redirect(['index', 'id_text' => $item->id_text, 'page' => $page]);
        $this->redirect(['view', 'id' => $item->id]);
    }

    public function actionDelete($id, $page = false)
    {
        $item = TextWord::findOne($id);
        $item->scenario = TextWord::SCENARIO_DELETE;
        $item->status = STATUS_INACTIVE;
        $item->save();
        $this->setMessage('Слово успешно удалено');
        return $this->redirect(['index', 'id_text' => $item->id_text, 'page' => $page ? $page : 1]);
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
        $sentenses = Sentense::find()->where(['id_text' => $id_text])->andWhere(['like', 'engl', $item->word->engl])->all();
        return $this->render('teach', compact('text', 'item', 'index', 'sentenses'));
    }

    public function actionStateIndex($id, $state, $page)
    {
        $item = TextWord::findOne($id);
        $this->setState($item, $state);
        $this->redirect(['index', 'id_text' => $item->id_text, 'page' => $page]);
    }

    public function actionStateTeach($id, $index)
    {
        $item = TextWord::findOne($id);
        $this->setState($item, TextWord::STATE_LEARNED);
        $this->redirect(['teach', 'id_text' => $item->id_text, 'index' => $index]);
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
