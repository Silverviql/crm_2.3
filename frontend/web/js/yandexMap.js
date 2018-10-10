let searchControl,
    suggestView;

ymaps.ready(init);

function init(){
    suggestView = new ymaps.SuggestView('toMap');
    suggestView = new ymaps.SuggestView('fromMap');
    searchControl = new ymaps.control.SearchControl({
        options: {
            float: 'left',
            floatIndex: 100,
            noPlacemark: true
        }
    });
    geoObject('#toMap', '#toInput', '#toName');
    geoObject('#fromMap', '#fromInput', '#fromName');

    function geoObject(actionMap, actionInput, actionName){
        $(document).ready(function () {
            $(actionMap).on('change', function () {
                let value = $(this).val();
                searchControl.search(value).then(function () {
                    let geoOjectsArray = searchControl.getResultsArray();
                    if(geoOjectsArray.length){
                        console.log(geoOjectsArray);
                        let coordinat = geoOjectsArray[0].geometry.getCoordinates();
                        let name = geoOjectsArray[0].properties.get('name');
                        $(actionInput).val(coordinat);
                        $(actionName).val(name);
                    }
                });
            });
        })
    }
}