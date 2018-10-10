<?php
/**
 * Created by PhpStorm.
 * User: Rus
 * Date: 13.10.2017
 * Time: 13:29
 */

namespace frontend\components;

use yii\base\Widget;

class YandexMap extends Widget
{
    public $index;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->view->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
        if ($this->index == 'courier'){
            $this->view->registerJsFile('@web/js/yandexMap.js');
        } else {
            $this->view->registerJs('
            let searchControl,
            suggestView;
        
        ymaps.ready(init);
        
        function init(){
            suggestView = new ymaps.SuggestView("toMap");
            searchControl = new ymaps.control.SearchControl({
                options: {
                    float: "left",
                    floatIndex: 100,
                    noPlacemark: true
                }
            });
        
            $("#toMap").on("change", function () {
                let value = $(this).val();
                searchControl.search(value).then(function () {
                    let geoOjectsArray = searchControl.getResultsArray();
                    if(geoOjectsArray.length){
                        console.log(geoOjectsArray);
                        let city = geoOjectsArray[0].properties.get("description");
                        let cityArr = city.split(",");
                        let coordinat = geoOjectsArray[0].geometry.getCoordinates();
                        let name = geoOjectsArray[0].properties.get("name");
                        $("#toInput").val(coordinat);
                        $("#toName").val(name);
                        $("#toCity").val(cityArr[2])
                    }
                });
            });
        }
            ');
        }
    }
}