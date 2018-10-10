<?php

namespace frontend\controllers;

use Yii;
use app\models\Cashbox;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class CashboxController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['manager'],

                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['shop'],

                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $array = Cashbox::getAll();
        return $this->render('index',['varInView' => $array]);
    }

    public function actionCreate()
    {

        $model = new Cashbox();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('update', 'Отчет успешно создан');
            return $this->redirect(['zakaz/shop']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }


    }

    protected function findModel($id)
    {
        if (($model = Cashbox::findOne($id)) !== null) {
            return $model;
        }
    }

}
