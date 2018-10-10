<?php

namespace test\controllers;

use Yii;
use app\models\Courier;
use app\models\Zakaz;
use app\models\CourierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
// use console\controllers\RbacController;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * CourierController implements the CRUD actions for Courier model.
 */
class CourierController extends Controller
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
           'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index'],
                'rules' => [
                   [
                       'actions' => ['index'],
                       'allow' => true,
                       'roles' => ['courier', 'program'],
                   ],
                   [
                    'actions' => ['ready'],
                    'allow' => true,
                    'roles' => ['courier', 'program'],
                   ],
                   [
                    'actions' => ['make'],
                    'allow' => true,
                    'roles' => ['courier', 'program'],
                   ],
                   [
                    'actions' => ['delivered'],
                    'allow' => true,
                    'roles' => ['courier', 'program'],
                   ],
                ],
            ],
        ];
    }

    /**
     * Lists all Courier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
     public function actionReady()
    {
        $courier = Courier::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $courier->andWhere(['>', 'data_from', '0000-00-00 00:00:00']),
            'pagination' => ['pageSize' => 50,]
            ]);
        
        return $this->render('ready', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Courier model.
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
     * Creates a new Courier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Courier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Courier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionMake($id)
    {
        $model = $this->findModel($id);
        $model->data_to = date('Y-m-d H:i:s');
        $model->status = 1;
        $model->save();

        return $this->redirect(['index']);
    }
    public function actionDelivered($id)
    {
        $model = $this->findModel($id);
        $model->data_from = date('Y-m-d H:i:s');
        $model->status = 2;
        $model->save();

        return $this->redirect(['index']);
    }
    /**
     * Finds the Courier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
