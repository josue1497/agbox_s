function readURL(input, img) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files.length) {
        var reader = new FileReader();
    
        reader.onload = function (e) {
            img.src=e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
    else{
        img.src='/assets/no_preview.png';
      }
    }

function toReadNotification(uri_to, uri_read, notification_id){
    $.post(uri_read,{notification_id:notification_id})
        .done(function(data){
            location.href =uri_to;
        }).fail(function() {
            alert( "error" );
        }) ;   
}

function toReadMessage(uri_to, uri_read, message_id){
    $.post(uri_read,{message_id:message_id})
        .done(function(data){
            location.href =uri_to;
        }).fail(function() {
            alert( "error" );
        }) ;  
         
}

function validateFields(){
    result = true;
    $('.form-control').each(function (index,item) {
        if($(this).attr('is_required')!==undefined &&$(this).attr('is_required').length>0){
            if($(this).val()==="0" || $(this).val()===""){
                $(this).parent().append("<div class=\"alert alert-danger mt-2\" role=\"alert\">"+
                "Este campo es requerido</div>")
                result=false;
            }
        }
    });
    return result;
}