<?php
/**
 * Created by PhpStorm.
 * User: holland
 * Date: 05.07.2017
 * Time: 14:15
 */

namespace frontend\components;

use app\models\Courier;
use app\models\Custom;
use app\models\Helpdesk;
use app\models\Todoist;
use app\models\Zakaz;
use Yii;
use yii\base\Widget;
use yii\bootstrap\Nav;


class Counter extends Widget
{
    private $params;

    public function init()
    {
        parent::init();

        $zakaz = Zakaz::find();
        $todoist = Todoist::find();
        $custom = Custom::find();
        $helpdesk = Helpdesk::find();
        $shipping = Courier::find();

        if (Yii::$app->user->can('shop')){
            $this->view->params['scoreZakazShop'] = $zakaz->andWhere(['id_sotrud' => Yii::$app->user->id, 'action' => 1])->count();
        } elseif (Yii::$app->user->can('design')){
            $this->view->params['scoreDesign'] = $zakaz->andWhere(['status' => [Zakaz::STATUS_DESIGN, Zakaz::STATUS_SUC_DESIGN, Zakaz::STATUS_DECLINED_DESIGN], 'action' => 1])->count();
        } elseif (Yii::$app->user->can('master')){
            $this->view->params['scoreMaster'] = $zakaz->andWhere(['status' => [Zakaz::STATUS_MASTER, Zakaz::STATUS_SUC_MASTER, Zakaz::STATUS_DECLINED_MASTER], 'action' => 1])->count();
        } elseif (Yii::$app->user->can('admin')){
            $this->view->params['scoreZakazAdmin'] = $zakaz->andWhere(['action' => 1])->andWhere(['!=', 'status' , Zakaz::STATUS_EXECUTE])->count();
        }
        if (Yii::$app->user->can('admin')){
            $this->view->params['scoreTodoistAdmin'] = $todoist->andWhere(['id_user' => Yii::$app->user->id])
                ->andWhere(['<>', 'activate', Todoist::CLOSE])
                ->count();
        } else {
            $this->view->params['scoreTodoist'] = $todoist->andWhere(['id_user' => Yii::$app->user->id])
                ->andWhere(['<>', 'activate', Todoist::CLOSE])
                ->count();
        }
        $this->view->params['scoreShippingAdmin'] = $shipping->andWhere(['<','status', Courier::RECEIVE])->count();
        $this->view->params['scoreShipping'] = $shipping->andWhere(['<','status', Courier::DELIVERED])->count();
        if (Yii::$app->user->can('system')){
            $this->view->params['scoreHelp'] = $helpdesk->andWhere(['status' => [Helpdesk::STATUS_NEW,Helpdesk::STATUS_CHECKING,Helpdesk::STATUS_DECLINED]])->count();
        } else {
            $this->view->params['scoreHelp'] = $helpdesk->andWhere(['id_user' => Yii::$app->user->id, 'status' => [Helpdesk::STATUS_NEW,Helpdesk::STATUS_CHECKING,Helpdesk::STATUS_DECLINED]])->count();
        }
        if (Yii::$app->user)
            $this->view->params['scoreCustomZakup'] = $custom->andWhere(['action' => 0])->count();
        $this->view->params['scoreCustom'] = $custom->andWhere(['id_user' => Yii::$app->user->id, 'action' => 0])->count();
    }

    /**
     * @return string
     */
    public function run()
    {
        return Nav::widget([
            'options' => ['class' => 'nav nav-pills headerNav'],
            'items' => [
                ['label' => 'Главная', 'encode' => false,'url' => ['site/manager'], 'visible' => Yii::$app->user->can('manager')],
                ['label' => 'Заказы <span class="badge pull-right">'.$this->view->params['scoreZakazAdmin'].'</span>', 'encode' => false, 'url' => ['zakaz/admin'],'options' => ['class' => 'border-button-menu'],  'visible' => Yii::$app->user->can('seeAdmin')],
                ['label' => 'Заказы <span class="badge pull-right">'.$this->view->params['scoreZakazShop'].'</span>', 'encode' => false, 'url' => ['zakaz/shop'],'options' => ['class' => 'border-button-menu'],  'visible' => Yii::$app->user->can('seeShop')],
                ['label' => 'Заказы <span class="badge pull-right">'.$this->view->params['scoreDesign'].'</span>', 'encode' => false, 'url' => ['zakaz/design'], 'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('design')],
                ['label' => 'Заказы <span class="badge pull-right">'.$this->view->params['scoreMaster'].'</span>', 'encode' => false, 'url' => ['zakaz/master'], 'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('master')],
                ['label' => 'Доставки <span class="badge pull-right">'.$this->view->params['scoreShipping'].'</span>', 'encode' => false, 'url' => ['courier/index'],'options' => ['class' => 'border-button-menu'],  'visible' => Yii::$app->user->can('courier')],
                ['label' => 'Задачи <span class="badge pull-right">'.$this->view->params['scoreTodoistAdmin'].'</span>', 'url' => ['todoist/index'],'options' => ['class' => 'border-button-menu'],  'encode' => false, 'visible' => Yii::$app->user->can('admin')],
                ['label' => 'Закупки <span class="badge pull-right">'.$this->view->params['scoreCustom'].'</span>', 'encode' => false, 'url' => ['custom/adop'],'options' => ['class' => 'border-button-menu'],  'visible' => Yii::$app->user->can('seeAdop')],
                ['label' => 'Доставки <span class="badge pull-right">'.$this->view->params['scoreShippingAdmin'].'</span>', 'encode' => false, 'url' => ['courier/shipping'], 'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('admin')],
                ['label' => 'Закупки <span class="badge pull-right">'.$this->view->params['scoreCustomZakup'].'</span>', 'encode' => false,'url' => ['custom/index'], 'options' => ['class' => 'border-button-menu'],  'visible' => Yii::$app->user->can('zakup')],
                ['label' => 'Задачи <span class="badge pull-right">'.$this->view->params['scoreTodoist'].'</span>', 'encode' => false,'url' => ['todoist/shop'], 'visible' => !Yii::$app->user->can('seeManager')],
                ['label' => 'Задачи ', 'encode' => false,'url' => ['todoist/index'], 'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('manager')],
                ['label' => 'Аналитика', 'url' => ['site/analytics'],'options' => ['class' => 'border-button-menu'],  'visible' => Yii::$app->user->can('manager')],
                ['label' => 'Персонал', 'encode' => false,'url' => ['personnel/shifts'], 'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('manager')],
                ['label' => 'Отчеты', 'url' => ['cashbox/index'],'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('manager')],
                ['label' => 'Партнеры',  'url' => ['partners/index'], 'options' => ['class' => 'border-button-menu'], 'visible' => Yii::$app->user->can('admin')],
                /* [
                     'label' => 'Dropdown',
                     'items' => [
                         ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                         '<li class="divider"></li>',
                         '<li class="dropdown-header">Dropdown Header</li>',
                         ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                     ],
                 ],*/
            ],
        ]);
    }
}