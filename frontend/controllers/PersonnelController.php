<?php

namespace frontend\controllers;

use app\models\Financy;
use app\models\Fine;
use app\models\Payroll;
use app\models\PersonnelPosition;
use app\models\Shifts;
use Yii;
use app\models\Personnel;
use app\models\PersonnelSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PersonnelController implements the CRUD actions for Personnel model.
 */
class PersonnelController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['shifts', 'view', 'create', 'update', 'lay-off', 'calculate','delete'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ]
                ]
            ],
        ];
    }

    /**
     * Lists all Personnel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonnelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personnel model.
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
     * Creates a new Personnel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personnel();
        $position = new PersonnelPosition();

        if ($model->load(Yii::$app->request->post()) && $position->load(Yii::$app->request->post()) && $model->save()) {
            $position->personnel_id = $model->id;
            $position->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'position' => $position
            ]);
        }
    }

    /**
     * Updates an existing Personnel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $position = new PersonnelPosition();

        if ($model->load(Yii::$app->request->post()) && $position->load(Yii::$app->request->post()) && $model->save()) {
            $position->personnel_id = $id;
            $position->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'position' => $position,
            ]);
        }
    }

    /**
     * Those who work as employees
     * @return string
     */
    public function actionShifts()
    {
        $searchModel = new PersonnelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('shifts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Layoff employee
     * if success it happens redirected on shifts
     * @param $id
     * @return \yii\web\Response
     */
    public function actionLayOff($id)
    {
        $model = $this->findModel($id);
        $model->action = 1;
        $model->save();
        Yii::$app->session->addFlash('update', 'Сотрудник '.$model->nameSotrud.' был уволен');
        return $this->redirect('shifts');
    }

    /**
     * Calculation with employees
     * if success then there is a redirected shifts
     * @param $id
     * @param $sum
     * @return \yii\web\Response
     */
    public function actionCalculate($id, $sum, $name)
    {
        $model = new Payroll();
        $financy = new Financy();
        $financy->scenario = 'employee';

        /** Payroll models */
        $model->personnel_id = $id;
        $model->sum = $sum;

        /** Financ models */
        $financy->sum = $sum;
        $financy->id_user = Yii::$app->user->id;
        $financy->id_employee = $id;
        $financy->category = Financy::SALARY;
        $financy->comment = 'Расчет зарплаты '.$name;

        $financy->save();
        $model->save();

        Yii::$app->session->addFlash('update', 'Произведен расчет '.$model->sum);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Personnel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Personnel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Personnel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personnel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
