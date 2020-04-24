<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
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
    private $pageSize = 8;
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
        $searchModel = new TextWordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id_text, $this->pageSize);
        $statistics = TextWord::getStatistics($id_text);
        return $this->render('index', compact('searchModel', 'dataProvider', 'text', 'statistics'));
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
        $item->deleteWord();
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

    public function actionSounds($id_text) 
    {
        $state = TextWord::STATE_NOT_LEARNED;
        $words_str = Word::createSoundsString($state, $id_text);
        return $this->render('sounds', compact('words_str', 'id_text'));
    }

    public function actionStateIndex($id, $state, $page)
    {
        $item = TextWord::findOne($id);
        $this->setState($item, $state);
        $this->redirect(['index', 'id_text' => $item->id_text, 'page' => $page]);
    }
    //for all word on page
    public function actionStatePage($id_text, $page)
    {
        if (!$page || $page == 1) $offset = 0;
        else $offset = ($page - 1) * $this->pageSize;
        $items = TextWord::find()->where(['id_text' => $id_text, 'status' => STATUS_ACTIVE])
        ->limit($this->pageSize)->offset($offset)->all();
        if ($items) {
           foreach ($items as $item) {
                $this->setState($item, TextWord::STATE_LEARNED);
           } 
        }
        $this->redirect(['index', 'id_text' => $id_text, 'page' => $page]);
    }

    public function actionStateTeach($id, $index)
    {
        $item = TextWord::findOne($id);
        $this->setState($item, TextWord::STATE_LEARNED);
        $this->redirect(['teach', 'id_text' => $item->id_text, 'index' => $index]);
    }

    public function actionStateList($ids, $state = TextWord::STATE_LEARNED, $id_text) {
        $ids = explode(',', rtrim($ids, ','));
        $words = Word::findAll($ids);
        foreach ($words as $word) {
            $word->setState($state);
            $items = TextWord::findAll(['id_word' => $word->id]);
            foreach ($items as $item) {
                $item->setState($state);
            }
        }
        $this->setMessage('Состояние слов изменено')->redirect(['sounds', 'id_text' => $id_text]);
    }

    //set state for all same words in texts and table words
    private function setState($item, $state)
    {
        $items = TextWord::findAll(['id_word' => $item->id_word]);
        foreach ($items as $elem) {
            $elem->setState($state);
        }
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
