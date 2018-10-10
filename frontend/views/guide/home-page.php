<?php
/**
 * Created by PhpStorm.
 * User: Rus
 * Date: 18.10.2017
 * Time: 10:12
 */
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\Guide */
/** @var $searchModel \yii\data\ActiveDataProvider */
$this->title = 'Guide';
?>

<div class="post-view">
    <div class="col-lg-2">
        <?php echo $this->render('_search', ['model' => $searchModel])?>
        <?php foreach ($model as $post){
            echo Html::a($post->title, ['post', 'id' => $post->id]).'<br>';
        } ?>
    </div>
    <div class="col-lg-9">
        <h2><?= Html::encode('Главная страница') ?></h2>
        <div class="col-lg-12">
            <div class="row">
            <?php foreach ($model as $post){
                echo '<div class="col-lg-6">';
                        echo '<a href="'.\yii\helpers\Url::to(['guide/post', 'id' => $post->id]).'">';
                        echo '<div class="guideTitleImg"><div class="guideImg">'.Html::img('@web/'.$post->attachment)
                                .'<h3 style="">'.$post->title.'</h3>'.
                            '</div></div>';
                        echo '</a>';
                echo '</div>';
            } ?>
            </div>
        </div>
    </div>
</div>