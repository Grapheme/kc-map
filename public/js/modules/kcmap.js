/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){

    $(".remove-object").click(function() {
        var $this = this;
        $.SmartMessageBox({
            title : "Удалить объект?",
            content : "",
            buttons : '[Нет][Да]'
        },function(ButtonPressed) {
            if(ButtonPressed == "Да") {
                $.ajax({
                    url: $($this).parent('form').attr('action'),
                    type: 'DELETE',dataType: 'json',
                    beforeSend: function(){$($this).elementDisabled(true);},
                    success: function(response,textStatus,xhr){
                        if(response.status == true){
                            showMessage.constructor('Удаление новости',response.responseText);
                            showMessage.smallSuccess();
                            $($this).parents('tr').fadeOut(500,function(){$(this).remove();});
                        }else{
                            $($this).elementDisabled(false);
                            showMessage.constructor('Удаление объекта','Возникла ошибка.Обновите страницу и повторите снова');
                            showMessage.smallError();
                        }
                    },
                    error: function(xhr,textStatus,errorThrown){
                        $($this).elementDisabled(false);
                        showMessage.constructor('Удаление объекта','Возникла ошибка.Повторите снова');
                        showMessage.smallError();
                    }
                });
            }
        });
        return false;
    });
});

function runFormValidation() {

    var kcObjects = $("#kcmap-form").validate({
        rules:{
            title: {required : true},
            description: {required : true}
        },
        messages : {
            title : {required : 'Укажите наименовани объекта'},
            description : {required : 'Укажите примечание'}
        },
        errorPlacement : function(error, element){error.insertAfter(element.parent());},
        submitHandler: function(form) {
            var options = {target: null,dataType:'json',type:'post'};
            options.beforeSubmit = function(formData,jqForm,options){
                $(form).find('.btn-form-submit').elementDisabled(true);
            },
            options.success = function(response,status,xhr,jqForm){
                $(form).find('.btn-form-submit').elementDisabled(false);
                if(response.status){
                    if(response.redirect !== false){
                        BASIC.RedirectTO(response.redirect);
                    }
                    showMessage.constructor(response.responseText,'');
                    showMessage.smallSuccess();
                }else{
                    showMessage.constructor(response.responseText,response.responseErrorText);
                    showMessage.smallError();
                }
            }
            $(form).ajaxSubmit(options);
        }
    });
}