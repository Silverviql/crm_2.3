<?php

namespace test\controllers;

use Yii;
use app\models\Todoist;
use app\models\Helpdesk;
use app\models\Custom;
use yii\base\Model;
use app\models\TodoistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TodoistController implements the CRUD actions for Todoist model.
 */
class TodoistController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Todoist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TodoistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Todoist shop models.
     * @return mixed
     */
    public function actionShop()
    {
        $searchModel = new TodoistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('shop', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Todoist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Todoist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Todoist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Todoist shop model.
     * If creation is successful, the browser will be redirected to the 'shop' page.
     * @return mixed
     */
    public function actionCreate_shop()
    {
        $model = new Todoist();
        $helpdesk = new Helpdesk();
        $models = [new Custom()];
        $data = Yii::$app->request->post('Custom', []);
        foreach (array_keys($data) as $index) {
            $models[$index] = new Custom();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['shop']);
        } elseif ($helpdesk->load(Yii::$app->request->post()) && $helpdesk->save()) {
            return $this->redirect(['shop']); 
        } elseif (Model::loadMultiple($models, Yii::$app->request->post())) {
            foreach ($models as $custom) {
                $custom->save();
            }
            return $this->redirect(['shop']);
        }
        else {
            return $this->render('create_shop', [
                'model' => $model,
                'helpdesk' => $helpdesk,
                'models' => $models,
            ]);
        }
    }

    /**
     * Updates an existing Todoist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Todoist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCreatezakaz($id_zakaz)
    {
        $model = new Todoist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('createzakaz', ['model' => $model,]);
        }
    }

    /**
     * Finds the Todoist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Todoist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Todoist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
