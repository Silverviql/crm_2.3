<?php

use yii\helpers\Html;
use app\models\Otdel;
use app\models\Zakaz;
use yii\bootstrap\Nav;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php Pjax::begin(); ?>

<h1>Добро пожаловать</h1>

<p>
	<h4>Версия 1.0</h4>
	<ul>
		<li>Создание таблицы</li>
		<li>Взаимодействие с отделами</li>
		<li>Сохрание и загрузка файлов</li>
		<li>Создание и редактирование заказов</li>
	</ul>
    <hr>
	<h4>Версия 1.1</h4>
    <ul>
        <li>Добавлено поле "сотрудник" в создание заказа</li>
        <li>Оптимизирована таблица</li>
        <li>В id указывается префикс</li>
        <li>У дизайнер добавлены внутренние этапы</li>
        <li>Убран во всех заказах магазин</li>
        <li>Теперь может магазин закрывать заказы</li>
        <li>Заказ можно закрыть только в том случае, если он в статусе исполнен</li>
    </ul>
    <hr>
	<h4>Версия 2.0</h4>
    <ul>
        <li>Созданы уведомление</li>
        <li>У администратора реализовано условное форматирование. При просроченном сроке цвет строки меняется на красный. Новые заказы меняются на жирный шрифт</li>
        <li>Простой поиск</li>
        <li>Добавлен задачник, helpdesk, запросы на получение товара</li>
        <li>Задачу можно прикреплять внутри заказа</li>
        <li>Сократилась ссылка</li>
        <li>У магазина убраны этапы</li>
        <!--<li>Магазин может искать заказ по части имени</li>-->
        <li>После авторизации переходит на экран заказов</li>
        <li>Создана роль закупщика</li>
        <li>Кликабельность заказов в таблице</li>
       <!-- <li>Добавлено автообновление страницы у админа, мастер и дизайнера</li>-->
       <!-- <li>Уведомление по движению заказа</li>-->
      <!--  <li>Реализована напоминалка</li>-->
      <!--  <li>Внутри заказа можно выходит уведомление если заказ просроченный или закрыт и описано как его восстановить</li>-->
        <li>Админ при создание доставки должен указывать внутрение сроки доставки</li>
        <li>Преобразована навигационная панель, убрано страница главная</li>
    </ul>
    <hr>
     <h4>Версия 2.1</h4>
    <ul>
        <li>Преобразован интерфейс crm</li>
        <li>Кнопка создать объединяет в списке запросы, заказы, починку, задачник, где пользователя переводит на конкретную страницу. Данная кнопка зафиксирована и поэтому будет везде находится на экране.</li>
        <li>Убран полный просмотр заказа и редактирование, сейчас во всех заказах, можно развернуть заказ и посмотреть информацию о заказе и там же редактировать его можно, указать доставку, задачу и запрос.</li>
        <li>Все архивы и завершенные задачи, заказы, доставки переносится вниз</li>
        <li>Теперь админ может видеть все доставки и удалять доставки до того как курьер еще не забрал товар</li>
        <li>Преобразован внешний вид загрузка изображение</li>
      <!--  <li>Система принятие и отклонение заказов</li>-->
    </ul>
    <hr>
    <h4>Версия 2.1.1</h4>
    <ul>
        <li>Добавились о внутренней навигации количество активных заказов.</li>
        <li>Создание запрос на товар переместился в окно "всех запросов"</li>
        <li>Внедрены в поломках принятие или отклонение.</li>
    </ul>
    <hr>
    <h4>Версия 2.1.2</h4>
    <ul>
        <li>Страница "Поломки" на 2 таблицы в работе и на проверке.</li>
    </ul>
    <hr>
    <h4>Версия 2.1.3</h4>
    <ul>
        <li>Появилось push-уведомление через telegram bot.</li>
        <li>Стилизованы подтверждение действие у пользователя</li>
    </ul>
    <hr>
    <h4>Версия 2.1.4</h4>
    <ul>
        <li>В задачнике появились 2 блока "Свои" и "Поставленные". Теперь каждый может ставить задачу другому также и себе.</li>
    </ul>
    <hr>
    <h4>Версия 2.1.5</h4>
    <ul>
        <li>Теперь имеется принятие и отклонение у задач. Если было отклонена задачи, то чтобы увидеть причину отказа в подсказках.</li>
        <li>В CRM появился список контактов всех сотрудников компании</li>
    </ul>
    <hr>
    <h4>Версия 2.2</h4>
    <ul>
        <li>Добавились в задачах комментирии, выводятся последние 3 комментарии. Также редактировать, переназначать и отменять задачи.
            Еще возможно прикрепить приложение в задачи</li>
    </ul>
    <hr>
        <h4>Версия 2.3</h4>
    <ul>
         <li>Общее</li>
         <ul>
            <li>Мобильная версия меню</li>
            <li>Закреплена шапка сайта</li>
            <li>Исправлена ошибка в отображение количество заказов в меню на кнопке заказов (заказы на закрытие больше не учитываются)</li>
            <li>Сортировка заказов по сроку исполнению и статусу (важно/очень важно/брак)</li>
            <li>На вкладке Партнеры добавлены поля whatsapp/график работы </li>
            <li>Убрана пагинация на странице заказов</li>
         </ul>
        <li>Добавлена роль Управляющего</li>
        <ul>
            <li>У управляющего появилась страница просмотра заказов каждого сотрудника</li>
            <li>Страница управление персоналом для управляющего</li>
            <li>Страница 'админской аналитики' для просмотра доходов по заказам (за вчера, за неделю)</li>
            <li>Страница 'Аналитики заказов' для просмотра статистики по заказам и доставки курьера</li>
            <li>Страница отчета по кассам от сотрудников магазина</li>
            <li>На странице контакты добавлена возможность создать/удалить/отредактировать сотрудников</li>
         </ul>
         <li>Магазин</li>
         <ul>
            <li>Добавлена возможность создания "отчета по закрытию кассы"</li>
            <li>В редактирование заказа нельзя указать стоймость заказа</li>
              <li>Добавлен чекбокс брак в заказе, с соответсвующий иконкой на главной странице с заказами</li>
         </ul>
          <li>Админ</li>
         <ul>
            <li>При редактирование заказа ( если он не указана оплата) нельзя назначить исполнителя</li>
            <li>На странице всех заказов при развертывания заказа в статусе нельзя назначить исполнителя пока оплата < 0</li>
            <li>В редактирование заказа нельзя указать оплату заказа (Кроме своих заказов)</li>
            <li>Добавлен чекбокс внутреннего заказа, с соответсвующий иконкой на главной странице с заказами</li>
            <li>В архиве больше нельзя редактировать заказ, если заказ был восставновлен появляется соотвествующая иконка</li>
            <li>Если Стоймость != Оплачено , заказ закрыть нельзя.</li>
            <li>Запрет на переназначение с магазина на администратора.</li>
            <li>При назначение заказа на исполнителя записывается срок выполнения в отдельное поле бд.</li>
         </ul>
         <li>Дизайнер</li>
         <ul>
            <li>Теперь можно добалять макет на этапе согласованием с администратором</li>
             <li>Изменение цвета заказов если они просрочены у дизайнера</li>
         </ul>
          <li>Курьер</li>
         <ul>
            <li>Дата закрытия доставки сохраняется в бд</li>
         </ul>
    </ul>
     <hr>
    <h4>Версия 2.3.1 (Тестовая)</h4>
    <ul>
        <li>Уведомление о всех этапах выполнения заказа</li>
        <li>Добавлена возможность загрузки exel файла в бд</li>
        <li>Теги для заказов</li>
        <li>Напоминание по заказу</li>
        <li>Переход по якорю у задачи с уведомления</li>
         <ul>
        <li>Магазин может закрывать доставку у курьера (только у заказов)</li>
        <li>В форме доставки поле куда выпадающим списком магазинов</li>
         </ul>
        <li>Срок у заказов указывает только дату (время отдельным полем) добавлена кнопка сегодня по умолчанию ( если дата не выбрана то ставится сегоднящняя)</li>
        <li>Улучшенный поиск в архиве и на странице заказов</li>
         <li>У магазина - в сроке добавить кнопку/галку "крайний срок!" Эту пометку к заказу должен видеть в строчном режиме и админ в т.ч. (?). 
         нужно понимать -какие заказы априоры неподвижны по срокам</li>
         <li>Все действия с заказами теперь в модальных окнах</li>
         <li>AJAX отправка данных для записи в бд</li>
         <li>Отображение отредактированных заказов черным ( Если <li>Все действия с заказами теперь в модальных окнах</li> магазин отредактировал заказ, админ этого не видел как и диз и мастер statusUpdate).</li>
         <li>Сокеты пуш для подписки на обновление по заказу</li>
         <li>PJAX обновление заказов ( без перезагрузки страницы)</li>
         <li>Связанные списки для описание заказа( футболка-> размер->цвет и т.д</li>
    </ul>
    <hr>
</p>


<div class="alert alert-info col-xs-4"><h2>Тех поддержка:</h2><br><span class="glyphicon glyphicon-earphone"></span> 89991556697 <br>
<span>@</span> holland.itkzn@gmail.com</div>
<?php Pjax::end(); ?>
