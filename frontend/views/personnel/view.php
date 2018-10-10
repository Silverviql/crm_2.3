<?php

use app\models\Personnel;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Shifts */
/* @var $modelPersonnel app\models\Personnel */
/* @var $position app\models\Position */
/* @var $sumShifts app\models\Shifts */
/* @var $sumWage app\models\Financy */
/* @var $financy app\models\Financy */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $modelPersonnel->nameSotrud;
foreach ($modelPersonnel->positions as $key => $value){
    $salary = $value->salary;
}
if ($modelPersonnel->shedule == Personnel::SHEDULE_DOUBLE){
    $shedule = 15;
    $timeWork = 12;
} else {
    $shedule = 20;
    $timeWork = 8;
}
$bonus = $modelPersonnel->bonus;
$salaryPrize = $salary+$bonus;
$sumTime = $salaryPrize/$shedule/$timeWork/60;
$wage = $sumShifts*$sumTime;
?>

<div class="col-lg-12">
    <?=Html::submitButton('Назначить', [
            'class' => 'btn btn-success financy',
            'value' => Url::to(['financy/charge', 'id' => $modelPersonnel->id])
        ]) ?>
    <?php Modal::begin([
        'id' => 'financeModel'
    ]);
    echo '<div class="modalContent"></div>';
    Modal::end()?>
    <?= Html::a('Расчитать', ['calculate', 'id' => $modelPersonnel->id, 'sum' => round($wage+$sumWage,2), 'name' => $modelPersonnel->nameSotrud], ['class' => 'btn btn-primary']) ?>
</div>
<div class="col-lg-3">
    <h4><?= Html::encode('График работы '.$modelPersonnel->sheduleName) ?></h4>
    <h3><?=Html::encode('Смены') ?></h3>
        <?php if (!$model){
            echo 'Ничего не найдена';
        } else {
            echo '<table>
            <tr>
                <th>Дата</th>
                <th>Количество часов</th>
            </tr>';
            foreach ($model as $shifts){
                echo '<tr><td style="padding: 8px">'.Yii::$app->formatter->asDate($shifts->start).'</td>
                <td style="padding: 8px">'.intval($shifts->number/60).'</td></tr>';
            }
            /** @var string $sumShifts */
            echo '<tr>
            <th>Итого</th>
            <th>'.intval($sumShifts/60).' часов</th>
        </tr>
    </table>';
    }?>
</div>
<div class="col-lg-5">
    <h3><?=Html::encode('Штрафы/Премия') ?></h3>
    <?php if (!$financy){
        echo 'Ничего не найдена';
    } else {
        echo '<table>';
        echo '<tr>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Коммент</th>
                <th>Штраф/Премия</th>
</tr>';
        foreach ($financy as $fin) {
            echo '<tr><td style="padding: 8px">'.Yii::$app->formatter->asDate($fin->date).'</td>
            <td style="padding: 8px">'.$fin->sum.' рублей</td>
            <td style="padding: 8px">'.$fin->comment.'</td>
            <td style="padding: 8px">'.$fin->categoryName.'</td></tr>';
        }
        echo '<tr>
            <th>Итого</th>
            <th>'.$sumWage.' рублей</th>
        </tr>';
       echo '</table>';
    }?>
</div>
<div class="col-lg-3">
    <h3><?= Html::encode('Зарплата') ?></h3>
    <div>Оклад:
        <?php echo number_format($salary, 0, ',', ' ').' рублей<br>' ?>
    </div>
    <div>Премия: <?php echo $modelPersonnel->bonus.' рублей' ?></div>
    <div>Итого: <?php echo '<b>'.number_format($wage,2, ',', ' ').'</b> рублей<br>';
        echo 'Штрафами и премиями '.number_format($wage+$sumWage, 2, ',', ' ').' рублей'; ?>
    </div>
</div>