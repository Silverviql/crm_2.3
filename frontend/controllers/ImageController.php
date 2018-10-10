<?php

namespace frontend\controllers;

use app\models\Image;
use yii\web\Controller;

class ImageController extends Controller
{
    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = Image::findOne($id);
        $model->delete();
        return $this->redirect(['test/test', 'id' => $model->question->id_theme]);
    }

}
