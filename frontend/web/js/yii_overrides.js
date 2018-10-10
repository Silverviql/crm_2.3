/**
 * Override the default yii confirm dialog. This function is
 * called by yii when a confirmation is requested.
 *
 * @param message
 * @param okCallback
 * @param cancelCallback
 */
yii.confirm = function (message, okCallback, cancelCallback) {
    swal({
        title: message,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Да',
        closeOnConfirm: true,
        cancelButtonText: 'Отменить',
        allowOutsideClick: true
    }, okCallback);
};