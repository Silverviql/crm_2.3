<?php

namespace frontend\controllers;
use app\models\ZakazSearch;
use yii\helpers\Json;
use Yii;
use yii\web\Controller;
use app\models\AnalyticsReport;
use app\models\AnalyticsSearch;


class AnalyticsController extends Controller
{


    public function actionIndex()
    {
//        // your default model and dataProvider generated by gii
//        $searchModel = new AnalyticsSearch;
//        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
//
//        // validate if there is a editable input saved via AJAX
//        if (Yii::$app->request->post('hasEditable')) {
//            // instantiate your analytics model for saving
//            $bookId = Yii::$app->request->post('editableKey');
//            $model = AnalyticsReport::findOne($bookId);
//
//            // store a default json response as desired by editable
//            $out = Json::encode(['output'=>'', 'message'=>'']);
//
//            // fetch the first entry in posted data (there should only be one entry
//            // anyway in this array for an editable submission)
//            // - $posted is the posted data for AnalyticsReport without any indexes
//            // - $post is the converted array for single model validation
//            $posted = current($_POST['Book']);
//            $post = ['Book' => $posted];
//
//            // load model like any single model validation
//            if ($model->load($post)) {
//                // can save model or do something before saving model
//                $model->save();
//
//                // custom output to return to be displayed as the editable grid cell
//                // data. Normally this is empty - whereby whatever value is edited by
//                // in the input by user is updated automatically.
//                $output = '';
//
//                // specific use case where you need to validate a specific
//                // editable column posted when you have more than one
//                // EditableColumn in the grid view. We evaluate here a
//                // check to see if buy_amount was posted for the AnalyticsReport model
//                if (isset($posted['buy_amount'])) {
//                    $output = Yii::$app->formatter->asDecimal($model->buy_amount, 2);
//                }
//
//                // similarly you can check if the name attribute was posted as well
//                // if (isset($posted['name'])) {
//                // $output = ''; // process as you need
//                // }
//                $out = Json::encode(['output'=>$output, 'message'=>'']);
//            }
//            // return ajax json encoded response and exit
//            echo $out;
//            return;
//        }
//
//        // non-ajax - render the grid by default
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//            'searchModel' => $searchModel
//        ]);
        $searchModel = new AnalyticsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }



}