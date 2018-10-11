<?php

/* @var $this yii\web\View */

use yii\bootstrap\Html;

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="jumbotron">
        <p class="lead">Если Вы ознакомились, то нажмите на "ОК"</p>

        <p>
        <?php if (Yii::$app->user->can('admin')): ?>
            <?= Html::a(Html::encode('ОК'), ['zakaz/admin'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('shop')): ?>
            <?= Html::a(Html::encode('ОК'), ['zakaz/shop'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('design')): ?>
            <?= Html::a(Html::encode('ОК'), ['zakaz/design'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('master')): ?>
            <?= Html::a(Html::encode('ОК'), ['zakaz/master'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('system')): ?>
            <?= Html::a(Html::encode('ОК'), ['helpdesk/index'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('zakup')): ?>
            <?= Html::a(Html::encode('ОК'), ['custom/index'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('courier')): ?>
            <?= Html::a(Html::encode('ОК'), ['courier/index'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('manager')): ?>
            <?= Html::a(Html::encode('ОК'), ['zakaz/index'], ['class' => 'btn btn-lg action']) ?>
        <?php endif; ?>
        </p>
    </div>

    <div class="container">
        <div></div>
    </div>
</div>

<h2><?= Html::encode('Сроки') ?></h2>
<div class="container srokIndex">
    <p>Кружка, футболка, пазлы, широкоформатная печать, печати, штампы, зеркала, часы, чехлы, бессмертный полк, магниты, календарики, брелки (все что связано с сублимацией, дизайнерские услуги – в течении 1 рабочего дня (заказы принятые до 13:00 будет в этот же день, заказы принятые позднее на следующий день) -  при реальной срочности у клиента, звонить менеджеру, либо Альберту.</p>
    <table>
        <tr>
            <td>Оцифровка аудио/фото/видео</td>
            <td>1 рабочий день</td>
        </tr>
        <tr>*если на оцифровку принесли от 3х и более кассет, оцифровка может занять 2 и более дней, в зависимости от количества
        </tr>
        <tr>
            <td>Значки</td>
            <td>1 рабочий день</td>
        </tr>
        <tr>
            <td>Печать на кепке</td>
            <td>1 рабочий день</td>
        </tr>
        <tr>
            <td>Холсты</td>
            <td>1-2 дня</td>
        </tr>
        <tr>
            <td>Баннеры, печать на ткани, пвх, печать больших наклеек</td>
            <td>1-2 дня</td>
        </tr>
        <tr>
            <td>Визитки 100шт</td>
            <td>В течение дня</td>
        </tr>
        <tr>
            <td>Визитки 500шт</td>
            <td>4 рабочих дней</td>
        </tr>
        <tr>
            <td>Визитки 1000шт</td>
            <td>3 рабочий день</td>
        </tr>
        <tr>
            <td>Керамика</td>
            <td>10 рабочих дней</td>
        </tr>
        <tr>
            <td>Листовки чб и цветные</td>
            <td>2-3 рабочих дня</td>
        </tr>
        <tr>
            <td>Евробуклеты</td>
            <td>4-5 рабочих дней</td>
        </tr>
        <tr>
            <td>Проявка</td>
            <td>2-3 рабочих дня</td>
        </tr>
        <tr>
            <td>Нашивки</td>
            <td>Около 2-х недель</td>
        </tr>
        <tr>
            <td>Фото книги</td>
            <td>1 неделя</td>
        </tr>
        <tr>
            <td>Пластиковые карты с чипированием, штрих код и т.д</td>
            <td>2-7 дней</td>
        </tr>
        <tr>
            <td>Бейджи пластиковые со сменным именем</td>
            <td>10 дней</td>
        </tr>
        <tr>
            <td>Оцветнение фото</td>
            <td>2 дня</td>
        </tr>
        <tr>
            <td>Заправка картриджей</td>
            <td>1-2 дня</td>
        </tr>
    </table>
    <div>
        Все сроки указаны с готовым макетом, либо после согласования макета.<br>
        Также мы изготавливаем ручки, флешки, зажигалки, телефоны, ноутбуки, ежедневники с печатью и гравировкой. –сроки 1-2 дня<br>
        Можем принимать вещи клиента для нанесения<br>
        Клиентов с такими заказами переправлять в офис - менеджеру (примеры того, то можем делать прикрепляю)
    </div>
</div>