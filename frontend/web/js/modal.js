$(document).ready(function() {
    modalView('.actionCancel', '#declinedModal');
    modalView('.actionApprove', '#acceptdModal');
    modalView('.modalDisain', '#modalFile');
    modalView('.declinedHelp', '#declinedHelpModal');
    modalView('.draft', '#draftModal');
    modalView('.modalShipping-button', '#modalShipping');
    modalView('.financy', '#financeModel');
    bodyModalView('.createClient', '#modalCreateClient', '.modalContentClient');
    bodyModalView('.declinedTodoist', '#modalDeclinedTodoist', '.modalContent');

    $('body').on('click', '.addNotice', function () {
        $('#create-modal_notify').modal('show')
    });

    function modalView(button, modal) {
        $(button).click(function (e) {
            e.preventDefault();
            $(modal).modal('show')
                .find('.modalContent')
                .load($(this).attr('value'));
        });
    }
    function bodyModalView(button, modal, content){
        $('body').on('click', button, function(e){
            e.preventDefault();
            $(modal).modal('show')
                .find(content)
                .load($(this).attr('value'))
        })
    }
});