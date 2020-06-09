<?php

namespace app\modules\word\controllers;

use Yii;
use yii\helpers\{ArrayHelper, Url};
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\{ActiveDataProvider, Pagination};
use app\modules\text\models\{Text, SubText};
use app\modules\word\models\ {Word, WordText, WordTextSearch};
use app\modules\string\models\ {FullString, Substring};


class WordTextController extends \app\controllers\BaseController
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

    public function actionIndex($text_id)
    {
        Url::remember();
        $searchModel = new WordTextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;
        $text = Text::findOne($text_id);
        $text->countStatistics($text->words);
        return $this->render('index', compact('searchModel', 'dataProvider', 'text'));
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->redirect(['/word/view', 'id' => $model->word->id]);
    }

    public function actionCreate($text_id)
    {
        Url::remember();
        return $this->redirect(['/word/create', 'text_id' => $text_id]);
    }

    public function actionUpdate($id)
    {
        Url::remember();
        $model = $this->findModel($id);
        $this->redirect(['/word/update', 'id' => $model->word_id]);
    }

    public function actionDelete($id)
    {
        Url::remember();
        $model = $this->findModel($id);
        return $this->redirect(['/word/delete', 'id' => $model->word->id]);
    }

    public function actionAddFromFiles($text_id = false)
    {
        $model = new WordText(['scenario' => WordText::SCENARIO_ADD_FILES]);

        if (Yii::$app->request->isPost) {
            $text_id = ArrayHelper::getValue(Yii::$app->request->post(), 'WordText.text_id');
            if ($model->addFromFiles($text_id)) {
                return $this->redirect(['index', 'text_id' => $text_id]);
            }
        }
        return $this->render('form_files', ['model' => $model, 'text_id' => $text_id]);
    }

    // public function actionGuess($id_text)
    // {
    //     $text = Text::findOne($id_text);
    //     $query = TextWord::find()->where(['id_text' => $id_text, 'status' => STATUS_ACTIVE]);
    //     $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);
    //     $words = $query->offset($pages->offset)->limit($pages->limit)->all();
    //     $engl = $words; $ru = $words; shuffle($ru);
    //     return $this->render('guess', compact('engl', 'ru', 'pages', 'text'));
    // }

    // public function actionWrite($id_text, $index = 0)
    // {
    //     $text = Text::findOne($id_text);
    //     $item = TextWord::getByIndex($id_text, $index);
    //     return $this->render('write', compact('text', 'item', 'index'));
    // }

    public function actionTeach($text_id, $index = 0)
    {
        Url::remember();
        $text = Text::findOne($text_id);
        $words = $text->sortItems($text->words, TYPE_NOT_LEARNED);
        if ($index < 0) $index = count($words);
        if ($index == count($words)) $index = 0;
        $word = $words[$index] ?? $words[$index + 1];
        return $this->render('teach', compact('text', 'word', 'words', 'index'));
    }

    public function actionSounds($text_id) 
    {
        $text = Text::findOne($text_id);
        $words = $text->sortItems($text->words, TYPE_NOT_LEARNED);
        $sounds_str = $text->createSoundsString($words);
        return $this->render('sounds', compact('sounds_str', 'text'));
    }

    public function actionRepeat($text_id, $subtext_id = false)
    {
        $text = Text::findOne($text_id);
        $subtext = SubText::findOne($subtext_id);
        $words = $subtext ? $subtext->words : $text->words;
        $words = $text->sortItems($words, STATE_NOT_LEARNED);
        return $this->render('repeat', compact('words', 'text', 'subtext_id'));
    }

    protected function findModel($id)
    {
        if (($model = TextWord::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
