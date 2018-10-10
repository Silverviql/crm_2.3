<?php
/**
 * Created by PhpStorm.
 * User: holland
 * Date: 27.07.2017
 * Time: 10:18
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = '@bower/sweetalert/dist';
    public $css = [
        'sweetalert.css',
    ];
    public $js = [
        'sweetalert.min.js'
    ];
}