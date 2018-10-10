<?php
use yii\helpers\Html;

/** @var $model app\models\Guide */
/** @var $posts app\models\Guide */
/** @var $searchModel \yii\data\ActiveDataProvider */
?>

<div class="post-view">
    <div class="col-lg-2">
        <?php echo $this->render('_search', ['model' => $searchModel])?>
        <?php foreach ($posts as $post){
            echo Html::a($post->title, ['post', 'id' => $post->id]).'<br>';
        } ?>
    </div>
    <div class="col-lg-9">
        <h2><?= Html::encode($model->title) ?></h2>
        <div class="col-lg-12">
            <p><?php echo '<b>Вопрос клиента: </b>'.$model->question ?></p>
            <p><?php echo '<b>Ответ сотрудника: </b>'.$model->answer ?></p>
            <p><?php echo '<b>Стардарты: </b>'.$model->standarts ?></p>
        </div>
    </div>
</div>
