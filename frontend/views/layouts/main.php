<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Notification;
use kartik\popover\PopoverX;
use frontend\components\Notifications;
use kartik\widgets\Growl;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\components\Counter;
use yii\bootstrap\ButtonDropdown;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
        <?php $this->registerLinkTag([
        'rel' => 'icon',
        'type' => 'image/x-icon',
        'href' => '/frontend/web/favicon.ico',
    ]);?>
    <?php $notifModel = Notification::find();
    $notifications = $notifModel->where(['id_user' => Yii::$app->user->id, 'active' => true]);
    $this->params['notifications'] = $notifications->all();
    $this->params['counter'] = $notifications->count(); ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
 <div class="container-fixed  col-lg-12 col-xs-12">
         <div class="row">
             <div class="col-lg-4 col-xs-2">
                 <?php if (!Yii::$app->user->isGuest): ?>
                 <div class="logo"></div>
                 <?php echo '<h1 class="titleMain ">'.Html::encode($this->title).'</h1>' ?>
             </div>
             <div class="col-lg-5 hidden-xs menu-vidget">
                     <?= Counter::widget() ?>
             </div>

<?php endif ?>
             <div class="col-lg-1 hidden-xs mt-2">
                 <?= Notifications::widget() ?>
             </div>
             <div class="col-lg-2 hidden-xs mt-2">
                 <?php $counts = '<span class="glyphicon glyphicon-bell" style="font-size:21px"></span><span class="badge pull-right">'.$this->params['count'].'</span>'; ?>
                 <?php
                 if (Yii::$app->user->isGuest) {
                     echo '';
                 } else {
                     PopoverX::begin([
                         'header' => '<i class="glyphicon glyphicon-lock"></i>Учетная запись',
                         'closeButton' => ['label' => false],
                         'placement' => PopoverX::ALIGN_BOTTOM,
                         'toggleButton' => ['label'=>'<span>'.Yii::$app->user->identity->name.'</span> <span class="glyphicon glyphicon-off exit"></span>', 'class' => 'btn btn-link logout'],
                     ]);
                     echo Html::a('Настройки', ['/site/setting', 'id' => Yii::$app->user->identity->id]).'<br>';
                     echo Html::a('Контакты', ['/personnel/index']).'<br>';
                     if(Yii::$app->user->can('shop')){
                         echo Html::a('Отчет по закрытию кассы', ['/cashbox/create']).'<br>';
                     }
                     echo Html::a('Инфорстенд', ['/site/index']).'<br>';
                     echo Html::beginForm(['/site/logout'], 'post');
                     echo Html::submitButton('Выход '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-lock']), ['class' => 'btn btn-primary']);
                     echo Html::endForm();

                     PopoverX::end();
                 }
                 ?>
             </div>
     </div>

             <div class="row">
                 <div class="col-xs-6 hidden-lg mt-1">
                     <?= Notifications::widget() ?>
                     <div class="menu-mobile">
                         <?php if (Yii::$app->user->isGuest) {
                             echo '';
                         } else {   echo ButtonDropdown::widget([
                             'label' => 'Menu',
                             'options' => ['class' => 'badge pull-right'],
                             'dropdown' => [
                                 'items' => [
                                     Counter::widget()
                                 ],
                             ],
                         ]); }?>
                     </div>
                 </div>
                 <div class="col-xs-6 hidden-lg mt-1">
                     <?php $counts = '<span class="glyphicon glyphicon-bell" style="font-size:21px"></span><span class="badge pull-right">'.$this->params['count'].'</span>'; ?>
                     <?php
                     if (Yii::$app->user->isGuest) {
                         echo '';
                     } else {
                         PopoverX::begin([
                             'header' => '<i class="glyphicon glyphicon-lock"></i>Учетная запись',
                             'closeButton' => ['label' => false],
                             'placement' => PopoverX::ALIGN_BOTTOM,
                             'toggleButton' => ['label'=>'<span>'.Yii::$app->user->identity->name.'</span> <span class="glyphicon glyphicon-off exit"></span>', 'class' => 'btn btn-link logout'],
                         ]);
                         echo Html::a('Настройки', ['/site/setting', 'id' => Yii::$app->user->identity->id]).'<br>';
                         echo Html::a('Контакты', ['/personnel/index']).'<br>';
                         echo Html::a('Инфорстенд', ['/site/index']).'<br>';

                         echo Html::beginForm(['/site/logout'], 'post');
                         echo Html::submitButton('Выход '.Html::tag('span', '', ['class' => 'glyphicon glyphicon-lock']), ['class' => 'btn btn-primary']);
                         echo Html::endForm();

                         PopoverX::end();
                     }
                     ?>
                 </div>
             </div>

    </div>
<?php if (Yii::$app->user->isGuest): ?>
    <div class="headerLogin">
        <h1>HOLLAND <span>CRM 2.3</span></h1>
        <p>Управление заказами</p>
    </div>
<?php endif ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Главная', 'url' => ['zakaz/index']],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?php if (Yii::$app->session->hasFlash('update')) {
            echo Growl::widget([
                'type' => Growl::TYPE_SUCCESS,
                'body' => Yii::$app->session->removeFlash('update'),
            ]);
        } ?>
        <?php if (Yii::$app->session->hasFlash('errors')) {
            echo Growl::widget([
                'type' => Growl::TYPE_DANGER,
                'body' => Yii::$app->session->removeFlash('errors'),
            ]);
        } ?>
        <?= $content ?>
    </div>
</div>
<?php if (Yii::$app->user->isGuest): ?>
    <footer>
        <div class="footerLogin">
            <img src="img/logo.png" title="Logo">
            <div>Сеть магазинов</div>
            <div>&copy Holland <?php echo date('Y') ?></div>
        </div>
    </footer>
<?php endif ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
