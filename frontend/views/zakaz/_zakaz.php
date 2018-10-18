<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\Courier;
use app\models\Comment;
use app\models\Zakaz;
use app\models\User;


/* @var $this yii\web\View */
/* @var $shipping app\models\Courier */
?>

<div class="">
    <div class="col-lg-2 view-zakaz" style="color: black">
	<div class=" anketaZakaz">
        <span class="anketaZakaz_from">От:</span>
        <div><?= date('d M H:i',strtotime($model->data)) ?></div>

<!--        <span class="anketaZakaz_from">Автор:</span>
        <div><?/*= $model->idSotrud->name */?></div>-->
        
        <?php if ($model->sotrud_name != null): ?>
        <span class="anketaZakaz_from">Сотрудник:</span>
        <div><?= $model->sotrud_name ?></div>
        <?php endif; ?>

        <span class="anketaZakaz_from">Клиент:</span>
        <div><?= $model->name ?></div>
        <div><?php $s = $model->phone;
        echo $s[0].' ('.$s[1].$s[2].$s[3].') '.$s[4].$s[5].$s[6].'-'.$s[7].$s[8].'-'.$s[9].$s[10]; ?></div>
        <div><?= $model->email ?></div>
	    </div>
    </div>
	<div class="col-lg-4 zakazInfo">
        <div class="divInform">
        <?= $model->information ?>
        </div>
    </div>
    <div  class="col-lg-2 orderComment">
          <span class="CommentOrder">Комментарии:</span>
        <?php $comment = Comment::find()->where(['id_zakaz' => $model->id_zakaz])->orderBy('id DESC')->limit(6)->all(); ?>
        <div class="comment-zakaz">
            <?php if (count($comment) != 0): ?>
            <?php foreach ($comment as $com): ?>
                <?php switch ($com->id_user){
                    case Yii::$app->user->id;
                        $user = 'Я';
                        break;
                    case (User::USER_DISAYNER);
                        $user = 'Дизайнер';
                        break;
                    case (User::USER_MASTER):
                        $user = 'Мастер';
                        break;
                }
                echo  '
        <div style="display: block;">
            <div class="userCommit">'.$user.':</div>
            <div class="comment">'.$com->comment.'</div>
            <div class="dateCommit">'.date('d.m H:i', strtotime($com->date)).'</div>
        </div>';
                ?>
            <?php endforeach; ?>
            <span class="nextComment" data-id="<?= $model->id_zakaz ?>" data-offset="1">Показать еще...</span>
            <?php else: ?>
                <span class="no-comments">Комментариев нет...</span>
            <?php endif; ?>
        </div>
    </div>
	<div class="col-lg-1 zakazFile">
        <div class="zakazFile_block">
            <span class="zakazFile_block-number">Кол-во:</span>
            <div><?= $model->number ?></div>
        </div>
        <div class="form_button_Layout">
		<?= Detailview::widget([
			'model' => $model,
			'options' => ['class' => 'table detail-view'],
			'template' => '<tr class="trMaket"><td{contentOptions} class="zakaz-view-kartik">{value}</td></tr></tr>',
			'attributes' => [
                [
                    'attribute' => 'maket',
                    'format' =>'raw',
                    'value' => $model->temporary_maket == null ? '<div class="maket"></div>' : Html::a('<span class="glyphicon glyphicon-saved imgZakaz maketView">', $model->maket, ['download' => true, 'data-pjax' => 0, 'title' => 'Готовый макет от дизайнера'])
                ],
				[
				    'attribute' => 'img',
                    'format' =>'raw',
                    'value' => $model->temporary_img == null ? '' : Html::a('<span class="glyphicon glyphicon-paperclip imgZakaz"></span>', $model->img, ['download' => true, 'data-pjax' => 0, 'title' => 'Исходный файл от клиента'])
				],
			],
		]) ?>
        </div>
	</div>
    <div class="col-lg-3 responsible">
        <?php if (Yii::$app->user->can('design')): ?>
            <?php if ($model->status == Zakaz::STATUS_DESIGN && $model->statusDesign == Zakaz::STATUS_DESIGNER_WORK): ?>
            Согласование с клиентом: <?= Html::a('Отправить', ['reconcilation', 'id' => $model->id_zakaz], ['class' => 'action']) ?>
            <?php endif ?>
            <?php if ($model->status == Zakaz::STATUS_DESIGN && $model->statusDesign == Zakaz::STATUS_DESIGNER_SOGLAS): ?>
                Согласование с клиентом: <?= Html::a('Снять', ['reconcilation', 'id' => $model->id_zakaz], ['class' => 'action']) ?>
            <?php endif ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('seeIspol')): ?>
            <div class="responsible_person-status">
                <?php if ($model->status == Zakaz::STATUS_DECLINED_DESIGN or $model->status == Zakaz::STATUS_DECLINED_MASTER){
                    echo '<div class="statusZakaz declinedIspol">Отклонено</div>
<div class="declinedIspol_div">
<span class="responsible_person">По причине:</span><br>'.$model->declined.'</div>';
                }
                ?>
            </div>
        <?php endif ?>
        <?php if (Yii::$app->user->can('admin')): ?>
<!--        <span class="responsible_person">Статус:</span>-->
        <div class="responsible_person-status">
            <?php if ($model->status == Zakaz::STATUS_SUC_DESIGN or $model->status == Zakaz::STATUS_SUC_MASTER){
                echo '<div class="statusZakaz">Выполнено</div>
<div>'
                    .Html::submitButton('Принять', ['class' => 'action actionApprove', 'value' => Url::to(['zakaz/accept', 'id' => $model->id_zakaz])]).' '
                    .Html::submitButton('Отклонить', ['class' => 'action actionCancel', 'value' => Url::to(['zakaz/declined', 'id' => $model->id_zakaz])]).'
</div>';
            }
            elseif($model->status == Zakaz::STATUS_DECLINED_DESIGN or $model->status == Zakaz::STATUS_DECLINED_MASTER){
                echo '<div class="statusZakaz declined">Отклонено</div>
<div class="declined_div">
<span class="responsible_person">По причине:</span><br>'.$model->declined.'</div>';
            } elseif($model->status == Zakaz::STATUS_ADOPTED){
                 if($model->oplata === 0 || $model->fact_oplata === 0 || $model->oplata === null || $model->fact_oplata === null ){
                    echo 'Заказ не олпачен, звони магазину.';
                }else{
                    echo Html::submitButton('Назначить', ['class' => 'action actionApprove appoint', 'value' => Url::to(['zakaz/accept', 'id' => $model->id_zakaz])]);
                }
            } elseif ($model->status == Zakaz::STATUS_AUTSORS){
                echo '<div class="statusZakaz">'.$model->idAutsors->name.'</div>
<div>'
                    .Html::submitButton('Принять', ['class' => 'action actionApprove', 'value' => Url::to(['zakaz/accept', 'id' => $model->id_zakaz])]).'
</div>';
            }
            ?>
        </div>
        <?php endif ?>
        <div class="col-lg-12 linePrice"></div>
        <div class="col-lg-12 oplata-zakaz">
                <div class="col-lg-6 block-price">
                    <span class="responsible_person">Оплачено:</span>
                    <span class="responsible_person">К доплате:</span>
                    <span class="responsible_person">Всего:</span>
                </div>
                <div class="col-lg-6 block-price">
                    <p class="responsible_person price"><?= number_format($model->fact_oplata, 0, ',', ' ').'р.' ?></p>
                    <p class="responsible_person price"><?php
                        if($model->oplata != null){
                            echo number_format($model->oplata - $model->fact_oplata,
                                    0, ',', ' ').'р.'; }
                        else{
                            echo number_format(0, 0, ',', ' ').'р.';
                        } ?></p>
                    <p class="responsible_person price "><?= number_format($model->oplata, 0, ',', ' ').'р.' ?></p>
                </div>
        </div>
    </div>
</div>
<div class="">
    <div class="col-lg-12 footerView"></div>
</div>
<div class="">
    <div class="col-lg-12 footer-view-zakaz">
        <?php if (($model->status == Zakaz::STATUS_MASTER or $model->status == Zakaz::STATUS_DECLINED_MASTER) && Yii::$app->user->can('master')): ?>
            <?= Html::a('Готово', ['check', 'id' => $model->id_zakaz], ['class' => 'btn btn- done']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('seeAdop')): ?>
            <?php if ($model->status == Zakaz::STATUS_EXECUTE && $model->action == 1): ?>
                <?= Html::a('Готово', ['close', 'id' => $model->id_zakaz], ['class' => 'btn btn-xs done']) ?>
            <?php endif ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('admin')): ?>
            <?php if($model->status == Zakaz::STATUS_ADOPTED && $model->action == 1): ?>
                <?= Html::a('Выполнить', ['fulfilled','id' => $model->id_zakaz], ['class' => 'btn btn-xs done']) ?>
            <?php endif ?>
            <?php if ($model->status == Zakaz::STATUS_AUTSORS && $model->action == 1): ?>
                <?= Html::a('Выполнить', ['fulfilled','id' => $model->id_zakaz], ['class' => 'btn btn-xs done']) ?>
            <?php endif ?>
            <?php if ($model->action == 0): ?>
                <?= Html::a('Восстановить', ['restore','id' => $model->id_zakaz], [
                        'class' => 'btn btn-xs done',
                        'data' => [
                            'confirm' => 'Вы действительно хотите восстановить заказ?',
                            'method' => 'post',
                        ],
                ]) ?>
            <?php endif ?>
        <?php endif ?>
        <?= Html::a('Задача', ['todoist/createzakaz', 'id_zakaz' => $model->id_zakaz], ['class' => 'btn btn-xs todoist']) ?>
        <?php if (Yii::$app->user->can('admin')): ?>            <?php Modal::begin([
                'header' => '<h2>Задание на доставку</h2>',
                'class' => 'model-sm modalShipping',
                'toggleButton' => [
                    'tag' => 'a',
                    'class' => 'btn btn-xs',
                    'label' => 'Доставка',
                ]
            ]);
            
            $shipping = new Courier();
            echo $this->render('shipping', [
                'shipping' => $shipping,
                'model' => $model->id_zakaz,
            ]);

            Modal::end(); ?>
        <?php endif ?>
        <?php if (($model->status == Zakaz::STATUS_DESIGN or $model->status == Zakaz::STATUS_DECLINED_DESIGN) && Yii::$app->user->can('design')): ?>
            <?= Html::submitButton('Заказ исполнен', ['class' => 'action modalDesign', 'value' => Url::to(['uploadedesign', 'id' => $model->id_zakaz])]) ?>
        <?php endif ?>
        <?php if (($model->status == Zakaz::STATUS_SUC_DESIGN or $model->status == Zakaz::STATUS_DECLINED_DESIGN) && Yii::$app->user->can('design')): ?>
        <?= Html::submitButton('Изменить макет', ['class' => 'action modalDesign', 'value' => Url::to(['uploadedesign', 'id' => $model->id_zakaz])]) ?>
        <?php endif ?>
        <?php if (!Yii::$app->user->can('seeIspol')): ?>
          <?php if ( $model->action !== 0 ): ?>
        <?= Html::a('Редактировать', ['zakaz/update', 'id' => $model->id_zakaz], ['class' => 'btn btn-xs', 'style' => 'float: right;margin-right: 10px;'])?>
        <?php endif ?>
        <?php endif ?>
        <?= Html::a('Полный просмотр', ['view', 'id' => $model->id_zakaz], ['class' => 'btn action']) ?>
<!--            --><?//= Html::a('Чек', ['#'], ['class' => 'btn btn-xs', 'style' => 'float: right;margin-right: 71px;'])?>
    </div>
</div>
    <?php
$user = Yii::$app->user->id;
$script = <<<JS
$('body').on('click', '.nextComment', function () {
           let id = $(this).data('id');
           let offset = $(this).data('offset');
           console.log(window.location.origin+'/comment/pagination?id='+id+'&offset='+offset);
           $.get(window.location.origin+'/comment/pagination?id='+id+'&offset='+offset)
               .done(res => {
                    console.log(res);
                   res = JSON.parse(res);
                   if (res.length === 0){
                       $(this).parent('.comment-zakaz').append('Комментариев нет...');
                       $(this).remove();
                   } else {
                        let com = res.map(comment => {
                           let user;
                           let date = new Date(comment.date);
                           let day = date.getDate();
                           let month = date.getMonth() + 1;
                           day = day < 10 ? '0'+ day : day;
                           month = month < 10 ? '0'+month : month;
                           switch (parseInt(comment.id_user)){
                               case $user:
                                   user = 'Я';
                                   break;
                               case 4:
                                   user = 'Дизайнер';
                                   break;
                               case 3:
                                   user = 'Мастер';
                                   break;
                           }
                           return '<div style="display: block;">'+
                                '<div class="userCommit">'+user+':</div>'+
                                '<div class="comment">'+comment.comment+'</div>'+
                                '<div class="dateCommit">'+day+' '+month+' '+date.getHours()+' '+date.getMinutes()+'</div>'+
                            '</div>'
                           });
                       $(this).parent('.comment-zakaz').append(com.join(' ')+
                       '<span class="nextComment" data-id="'+id+'" data-offset="'+offset + 1 +'">Показать еще...</span>');
                       $(this).remove();
                       console.log(res)   
                   }
               })
               .fail(err => console.error(err.responseText));
       });

JS;

$this->registerJs($script)
?>
