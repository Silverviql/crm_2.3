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
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!$model->save()) {
                print_r($model->getErrors());
                Yii::$app->session->addFlash('errors', 'Произошла ошибка!');
            } else {
                if (Yii::$app->request->isAjax) {
                    $model->save();
                    Yii::$app->session->addFlash('update', 'Отчет успешно создан');
                }
            }
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Cashbox::findOne($id)) !== null) {
            return $model;
        }
    }

}
