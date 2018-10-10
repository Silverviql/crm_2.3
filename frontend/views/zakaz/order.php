<?php

use app\models\Financy;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\Courier;
use app\models\Zakaz;
use yii\widgets\MaskedInput;

/* @var  $comment app\models\Comment */
/* @var  $model app\models\Zakaz */
/* @var  $client app\models\Client */
/** @var string $sotrud */
?>

<div class="view-zakaz" style="color: black">
    <div class="col-lg-2 anketaZakaz">
        <span class="anketaZakaz_from">От:</span>
        <div class="srok"><?= Yii::$app->formatter->asDatetime($model->data); ?>
            <span class="anketaZakaz_from">Автор:</span>
            <div><?= $model->idSotrud->name ?></div>

            <?php if ($model->shifts_id != null): ?>
                <span class="anketaZakaz_from">Сотрудник:</span>
                <div><?= $model->shifts->idSotrud->name ?></div>
            <?php endif; ?>

            <span class="anketaZakaz_from">Клиент:</span>
            <div><?php if ($model->name == null) {
                    echo $model->idClient->name;
                } else {
                    echo $model->name;
                } ?></div>
            <div>
                <?php if ($model->phone == null){
                    echo $model->idClient->phone;
                } else {
                    echo $model->phone;
                }  ?>
            </div>
            <div><?= $model->idClient->email ?></div>
        </div>
    </div>
    <div class="col-lg-7 zakazInfo">
        <div class="divInform">
            <?= $model->information ?>
        </div>
    </div>
    <div class="col-lg-1 zakazFile">
        <div class="zakazFile_block">
            <span class="zakazFile_block-number">Кол-во:</span>
            <div><?= $model->number ?></div>
        </div>
        <?= Detailview::widget([
            'model' => $model,
            'options' => ['class' => 'table detail-view'],
            'template' => '<tr class="trMaket"><td{contentOptions} class="zakaz-view-kartik">{value}</td></tr></tr>',
            'attributes' => [
                [
                    'attribute' => 'maket',
                    'format' =>'raw',
                    'value' => $model->maket == null ? '<div class="maket"></div>' : Html::a('<span class="glyphicon glyphicon-saved imgZakaz maketView">', '@web/maket/'.$model->maket, ['download' => true, 'data-pjax' => 0, 'title' => 'Готовый макет от дизайнера'])
                ],
                [
                    'attribute' => 'img',
                    'format' =>'raw',
                    'value' => $model->img == null ? '' : Html::a('<span class="glyphicon glyphicon-paperclip imgZakaz"></span>', '@web/attachment/'.$model->img, ['download' => true, 'data-pjax' => 0, 'title' => 'Исходный файл от клиента'])
                ],
            ],
        ]) ?>
    </div>
    <div class="responsible">
        <div class="responsible_person-status">
                <?php if ($model->status == Zakaz::STATUS_DECLINED_DISAIN or $model->status == Zakaz::STATUS_DECLINED_MASTER){
                    echo '<div class="statusZakaz declinedIspol">Отклонено</div>
<div class="declinedIspol_div">
<span class="responsible_person">По причине:</span><br>'.$model->declined.'</div>';
                }
                ?>
            </div>
            <span class="responsible_person">Статус:</span>
            <div class="responsible_person-status">
                <?php if ($model->status == Zakaz::STATUS_SUC_DISAIN or $model->status == Zakaz::STATUS_SUC_MASTER){
                    echo '<div class="statusZakaz">Выполнено</div>';
                } elseif ($model->renouncement != null){
                    echo '<div class="statusZakaz declined">Отказ от клиента</div>
<div class="declined_div">
<span class="responsible_person">По причине:</span><br>'.$model->renouncement.'</div>';
                } elseif ($model->status == Zakaz::STATUS_AUTSORS){
                    echo '<div class="statusZakaz">'.$model->idAutsors->name.'</div>';
                }
                ?>
            </div>
        <div class="linePrice"></div>
        <div class="oplata-zakaz">
            <span class="responsible_person namePrice">Оплачено:</span>
            <span class="responsible_person namePrice">К доплате:</span>
            <span class="responsible_person namePrice">Всего:</span>
            <div class="responsible_person price"><?= number_format($model->fact_oplata, 0, ',', ' ').'р.' ?></div>
            <div class="responsible_person price"><?php if($model->oplata != null){?>
                    <?php echo number_format($model->oplata - $model->fact_oplata, 0, ',', ' ').'р.'; ?>
                <?php } ?></div>
            <div class="responsible_person price"><?= number_format($model->oplata, 0, ',', ' ').'р.'    ?></div>
        </div>
    </div>