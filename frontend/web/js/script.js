// document.getElementById('notification').onclick = () => {
// 	document.getElementById('notification-container').classList.toggle('hidden');
// }
$(document).ready(function(){
 /*	setInterval(function(){
 		$.pjax.reload('#pjax-container')
 	}, 100000);*/
        let urlSite = window.location.origin;
        changeStatus('.trNew', urlSite+'/zakaz/adopted?id=');
        changeStatus('.trNewMaster', urlSite+'/zakaz/adopmaster?id=');
        changeStatus('.trNewDisain', urlSite+'/zakaz/adopdisain?id=');
        addClassForm('.startShift', '#form-startShift', '.form-shiftStart');
        addClassForm('.endShift', '#form-endShift', '.form-shiftEnd');

        $('body').on('click', '#notification-new', function (e) {
            e.preventDefault();
            $.get(`${urlSite}/notification/index?new=true`)
                .done(res => {
                    notificationView(res, 'Показать все уведомление', 'notification-all');
                })
                .fail(err => console.log(err.responseText))
        });
        $('body').on('click', '#notification-all', function (e) {
            e.preventDefault();
            let count = $(this).parents('.notification-info').data('count');
            $.get(`${urlSite}/notification/index`)
                .done(res => {
                    notificationView(res, `Новый уведомление: ${count}`, `notification-new`)
                })
                .fail(err => console.error(err.responseText))
        })

        $( 'body' ).on( 'click', '.commentButton', function() {
            $( ".CommentForm" ).toggleClass( "CommentForm-visible" );
        });
       $('body').on('change', '#zakaz-status', function () {
                $('#autsors')
                    .css({'display': ($(this).val() == 8 ? 'block' : 'none')})
                    .prop('selectedIndex', 0)
       });
       $('body').on('click', '#checkboxAppoint', function () {
           $('.form-appoint').toggleClass('visible');
       });
       $('#zakaz-status').each(function () {
            if ($(this).val() == 8){
                $('#autsors').css('display', 'block')
            } else {
                $('#autsors').css('display', 'none')
                    .prop('selectedIndex', 0);
            }
       });

       /** clicked on delivared from the buyer */
       $('.sendGood').click(function (e) {
           e.preventDefault();
           let url = $(this).attr('href');
           let id = $(this).attr('id');
           $.ajax({
               type: 'get',
               url: urlSite+''+url
           })
           .done(result => {
                   if(result === '1'){
                    $('#'+id).parents('tr').remove();
                    
                   }
                })
               .fail(err =>  console.error(err))
       });

    function addClassForm(button, form, formSecond){
        $(button).click(function () {
            $(form)[0].reset();
            $(formSecond).toggleClass('visibleForm');
        });
    }
      function changeStatus(tr, url) {
        $('body').on("click", tr, function () {
            let data = $(this).data("key");
            $.ajax({
                url: url+data,
            })
                .done(() => {
                    $(this).removeClass(tr.slice(1)+' bold');
                    $(this).children('td:nth-child(2)').addClass('textTr');
                    $(this).children('td:nth-child(4)').addClass('textTr');
                    $(this).children('td:nth-child(8)').addClass('textTr');
                })
                .fail(err => console.error(err))
        });
    }
    function notificationView(res, message, idName){
        res = JSON.parse(res);
        console.log(res);
        let style = '';
        let view = res.map(item => {
            if (idName === 'notification-new'){
                style = item.active === '1' ? 'font-weight:bold' : '';
            }
            return `<p><a href="${urlSite}/notification/open-notification?id=${item.id}" style="${style}">${item.name}</a></p>`
        }).join(' ');
        $('.notification-info').html(`<div class="notification-info_filter"><a id=${idName}>${message}</a></div>${view}`);
    }
    $(function () {
        $("[data-toggle = 'tooltip']").tooltip();
    });
    $(function () {
        $("[data-toggle='popover']").popover();
    });
});