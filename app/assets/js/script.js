$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('click','.call-model', function (e) {

    e.preventDefault();
    var el = $(this);
    var url = el.data('url');
    var target = el.data('target-modal');

    $.ajax({
        type: "GET",
        url: url
    }).always(function(){
        $('#load-modal').html(' ');
    }).done(function(res){
        $('#load-modal').html(res.html);
        $(target).modal('toggle');
    });

});
$(document).on('click' ,'.change-status', function (e) {

    var el = $(this);
    var url = el.data('url');
    var id = el.val();
    $.ajax({
        type: "POST",
        url: url,
        data: {
            id     : id,
            status : el.prop("checked"),
        }
    }).always(function(){
    }).done(function(respons){

        message.fire({
            type:  'success',
            title: 'Éxito',
            text:  respons.message
        });

    }).fail(function(){

        message.fire({
            type:  'error',
            title: 'Error',
            text:  '¡Algo salió mal, por favor inténtalo de nuevo!'
        });

    });

});
$(document).on('click' ,'.delete-confrim', function (e) {
    e.preventDefault();

    var el      = $(this);
    var url     = el.attr('href');
    var id      = el.data('id');
    var refresh = el.closest('table');

    message.fire({
        title:               '¿Estás seguro?',
        text:                '¡No podrás revertir esto!',
        type:                'warning',
        customClass: {
            confirmButton: 'btn btn-success shadow-sm mr-2',
            cancelButton:  'btn btn-danger shadow-sm'
        },
        buttonsStyling:      false,
        showCancelButton:    true,
        confirmButtonText:   '¡Sí, eliminar!',
        cancelButtonText:    '¡No, cancelar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id      : id,
                    _method : 'DELETE'
                }
            }).always(function(){
                $(refresh).DataTable().ajax.reload();
            }).done(function(respons){

                message.fire({
                    type:  'success',
                    title: 'Éxito',
                    text:  respons.message
                });

            }).fail(function(respons){
                console.log(respons.responseJSON);
                var res = respons.responseJSON;
                var msg = '¡Algo salió mal, por favor inténtalo de nuevo!';

                if (!res.success && res.status === 400) {
                    msg = res.message;
                }

                message.fire({
                    type:  'error',
                    title: 'Error',
                    text:  msg
                });

            });
        }
    });

});
if (jQuery().dataTable) {
    $.extend(true, $.fn.dataTable.defaults, {
        oLanguage: {
            oPaginate: {
                sNext:     '<span class="pagination-default"></span><span class="pagination-fa">Siguiente</span>',
                sPrevious: '<span class="pagination-default"></span><span class="pagination-fa">Anterior</span>'
            }
        }
    });
}

const toast = Swal.mixin({
    toast:             true,
    position:          'top-end',
    showConfirmButton: false,
    timer:             8000
});

const message = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success shadow-sm mr-2',
        cancelButton:  'btn btn-danger shadow-sm'
    },
    buttonsStyling: false,
});

if (jQuery().validate) {

    jQuery.validator.addMethod("phonenumber", function (value, element) {
        var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        return this.optional(element) || filter.test(value);
    }, 'Por favor, ingresa un número de teléfono válido.');

    $.validator.addMethod('filesize', function (value, element, param) {
        if (element.files.length) {
            return this.optional(element) || (element.files[0].size <= param);
        }
        return true;
    }, 'El tamaño del archivo debe ser inferior a 5 MB.');

    $.validator.addMethod('ckdata', function (value, element) {
        var editor = CKEDITOR.instances[$(element).attr('id')];
        return editor.getData().length > 0;
    }, 'Este campo es obligatorio.');

}

function ajaxindicatorstart(text) {
    if (jQuery('body').find('#resultLoading').attr('id') !== 'resultLoading') {
        jQuery('body').append(
            '<div id="resultLoading" style="display:none">' +
            '<div><img src=""><div>' + text + '</div></div>' +
            '<div class="bg"></div>' +
            '</div>'
        );
    }
    jQuery('#resultLoading').css({
        width:    '100%',
        height:   '100%',
        position: 'fixed',
        'z-index':'10000000',
        top:      '0',
        left:     '0',
        right:    '0',
        bottom:   '0',
        margin:   'auto'
    });
    jQuery('#resultLoading .bg').css({
        background: '#000',
        opacity:    0.7,
        width:      '100%',
        height:     '100%',
        position:   'absolute',
        top:        '0'
    });
    jQuery('#resultLoading>div:first').css({
        width:      '250px',
        height:     '75px',
        'text-align':'center',
        position:   'fixed',
        top:        '0',
        left:       '0',
        right:      '0',
        bottom:     '0',
        margin:     'auto',
        'font-size':'16px',
        'z-index':  10,
        color:      '#fff'
    });
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop() {
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}