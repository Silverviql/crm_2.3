<?php

use app\models\Questions;
use frontend\components\NavThema;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Image;

/** @var $model \app\models\Questions */
/** @var $thema \app\models\Thema */

$lenght = count($model) - 1;
?>

<div class="test-adminTest row">
    <div class="col-lg-2 navBar-Thema">
        <h3>Все тесты</h3>
        <?php echo NavThema::widget() ?>
        <?php Modal::begin([
            'header' => 'Создание теста',
            'toggleButton' => [
                'tag' => 'button',
                'class' => 'btn btn-primary btn-block button-thema-test',
                'label' => 'Создать тест'
            ]
        ]);

        echo $this->render('create');

        Modal::end()?>
    </div>
    <div class="col-lg-6 column-basic">
        <h1 class="column-basic-title"><?php echo 'Тест '.$model[0]->idThemeQuestion->name ?></h1>
        <span class="glyphicon glyphicon-edit editTitle" data-path="<?=Url::to(['test/update-theme', 'id' => $model[0]->id_theme])?>"></span>
        <span><?php Modal::begin([
                'header' => 'Создать вопрос',
                'toggleButton' => [
                    'tag' => 'span',
                    'class' => 'addQuestionButton',
                    'label' => '+'
                ]
            ]);
            echo $this->render('create', ['thema' => $thema]);
            Modal::end(); ?></span>
        <p>УСЛОВИЯ ПРОХОЖДЕНИЯ:</p>
        <p>Время на прохождение: 1 минута.</p>
        <p>Если Вы не прошли тест, пересдача возможна не ранее, чем через 14 дней. Результаты прохождения принимаются в расчет при начислении бонусов и премиальных, а также - при повышении должности.</p>
        <hr/>
        <?php foreach ($model as $count => $question){
            $number = $count+1;
            echo '<div class="test-block-admin">';
                echo '<div class="question-test-admin">';
                    echo '<div><h3> Вопрос '.$number.'</h3>';
                    echo '<span class="glyphicon glyphicon-edit editQuestion" data-path="'. Url::to(['test/update', 'id' => $question->id]).'"></span></div>';
                    echo '<div><p class="question-test-admin_name">'.$question->name.'</p></div>';
                    foreach ($question->answear as $key => $answear) {
                        echo '<label><input type="radio" class="radio" name="'.$question->id.'" value="'.$answear.'"><span class="answer">'.$answear.'</span></label><br/>';
                    }
                echo '</div>';
                if ($count == 0){
                    if ($lenght == 0) {
                        echo '';
                    } else {
                        echo Html::submitButton('>', ['class' => 'nextTestAdmin']);
                    }
                } else if ($count == $lenght){
                    echo Html::submitButton('<', ['class' => 'prevTestAdmin']);
                } else {
                    echo Html::submitButton('<', ['class' => 'prevTestAdmin']).' '.Html::submitButton('>', ['class' => 'nextTestAdminSecond']);
                }
                $file = Image::find()->where(['id_question' => $question->id])->all();
                echo '<div class="row">';
                foreach ($file as $attachment){
                    echo '<div class="col-lg-6">'.Html::img($attachment->path, ['style' => 'width:300px', 'class' => 'thumbnail']).'</div>';
                }
                echo '</div>';
            echo '</div>';
        } ?>
    </div>
    <div class="col-lg-3 statistics">
        <?= Html::a('Пройти тест', ['#'], ['class' => 'btn btn-success btn-lg btn-block passTest']) ?>
        <p>СПИСОК НАНАЧЕНИЙ</p>
        <hr/>
        <div class="statistics_appointment">
            <span class="glyphicon glyphicon-check statistics_appointment-icon"></span>
            <span class="statistics_appointment-date">15 мар</span>
            <span class="statistics_appointment-name">Руслан Абсалямов</span>
            <span class="statistics_appointment-result">13/15</span>
        </div>
        <div class="statistics_appointment">
            <span class="glyphicon glyphicon-retweet statistics_appointment-icon"></span>
            <span class="statistics_appointment-date">15 мар</span>
            <span class="statistics_appointment-name">Альберт Закиров</span>
            <span class="statistics_appointment-result">8/15</span>
        </div>
        <div class="form-search">
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-user form-search-icon"></span>
                <input type="text" class="form-control form-search-input" placeholder="Найти учстника">
                <span class="input-group-btn">
                    <button class="btn form-search-button" type="button">Назначить</button>
                </span>
            </div>
            <?= Html::submitButton('Создать ссылку на прохождение...', ['class' => 'btn btn-block addLinkButton']) ?>
        </div>
        <div class="statistics-paragraph">
            <p>СТАТИСТИКА</p>
            <hr/>
            <div class="col-lg-12 statistics-paragraph-result">
                <div class="col-lg-4">
                    <?= Html::img('@web/images/u3146.png', ['alt' => 'Статистика']) ?>
                </div>
                <div class="col-lg-8 statistics-paragraph-interest">
                    <p>Отлично (без ошибок): 60%</p>
                    <p>Сдали (1-3 ошибки): 30%</p>
                    <p>Не сдали (более 3 ошибок: 10%</p>
                </div>
            </div>
            <div class="col-lg-12 statistics-paragraph-result">
                <div class="col-lg-4">
                    <?= Html::img('@web/images/u3148.png', ['alt' => 'Статистика']) ?>
                </div>
                <div class="col-lg-8 statistics-paragraph-interest">
                    <p class="statistics-paragraph-interest_title">САМЫЕ ТЯЖЕЛЫЕ ВОПРОСЫ:</p>
                    <p>Вопрос №12 112 ошибок</p>
                    <p>Вопрос №2 89 ошибок</p>
                    <p>Вопрос №7 5 ошибок</p>
                </div>
            </div>
            <p>РЕКОМЕНДАЦИЯ</p>
            <hr/>
        </div>
    </div>
</div>
<?php Modal::begin([
    'id' => 'modal-editQuestion',
    'header' => 'Редактировние вопроса',
]);

echo '<div class="modal-content"></div>';

Modal::end(); ?>