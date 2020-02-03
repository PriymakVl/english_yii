<?php

namespace app\controllers;

use Yii;
use app\models\Text;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Category;

class TextController extends \app\controllers\BaseController
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
     * Lists all Text models.
     * @return mixed
     */
    public function actionIndex($cat_id = false)
    {
        $cat = Category::findOne($cat_id);

        $where = $cat_id ? ['status' => STATUS_ACTIVE, 'cat_id' => $cat_id] : ['status' => STATUS_ACTIVE];
        $dataProvider = new ActiveDataProvider([
            'query' => Text::find()->where($where),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider, 'cat' => $cat,
        ]);
    }

    /**
     * Displays a single Text model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', compact('model'));
    }

    /**
     * Creates a new Text model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cat_id)
    {
        $model = new Text();
        $cat = Category::findOne($cat_id);
        if ($cat->children) return $this->setMessage('В этой категории уже есть подкатегории', 'error')->back();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model, 'cat' => $cat,
        ]);
    }

    /**
     * Updates an existing Text model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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
     * Deletes an existing Text model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $this->setMessage("Текст успешно удален");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Text model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Text the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Text::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
