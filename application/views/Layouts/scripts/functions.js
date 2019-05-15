function readURL(input, img) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files.length) {
        var reader = new FileReader();

        reader.onload = function (e) {
            img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
    else {
        img.src = '/assets/no_preview.png';
    }
}

function toReadNotification(uri_to, uri_read, notification_id) {
    $.post(uri_read, { notification_id: notification_id })
        .done(function (data) {
            location.href = uri_to;
        }).fail(function () {
            alert("error");
        });
}

function toReadMessage(uri_to, uri_read, message_id) {
    $.post(uri_read, { message_id: message_id })
        .done(function (data) {
            location.href = uri_to;
        }).fail(function () {
            alert("error");
        });

}

function validateFields() {
    result = true;
    $('.form-control').each(function (index, item) {
        if ($(this).attr('is_required') !== undefined && $(this).attr('is_required').length > 0) {
            if ($(this).val() === "0" || $(this).val() === "") {
                $(this).parent().append("<div class=\"alert alert-danger mt-2\" role=\"alert\">" +
                    "Este campo es requerido</div>")
                result = false;
            }
        }
    });
    return result;
}

function maketoast(priority, title, message) {
    // evt.preventDefault();

    var options =
    {
        priority: priority || null,
        title: title || null,
        message: message || 'A message is required',
        settings: {
            'toaster': {
                'id': 'toaster',
                'container': 'body',
                'template': '<div></div>',
                'class': 'toaster',
                'css': {
                    'position': 'fixed',
                    'top': '10%',
                    'left': '70%',
                    'width': '90%',
                    'zIndex': 50000
                }
            },

            'toast': {
                'template':
                    '<div class="alert alert-%priority% alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '<span class="sr-only">Close</span>' +
                    '</button>' +
                    '<span class="title"></span>: <span class="message"></span>' +
                    '</div>',

                'defaults': {
                    'title': 'Notice',
                    'priority': 'success'
                },

                'css': {},
                'cssm': {},
                'csst': { 'fontWeight': 'bold' },
                'fade': 'slow',

                'display': function ($toast) {
                    return $toast.fadeIn('fast');
                },

                'remove': function ($toast, callback) {
                    return $toast.fadeOut('fast');
                }
            },

            'debug': false,
            'timeout': 2500,
            'stylesheet': null,
            'donotdismiss': []

        }
    };

    $.toaster(options);
}

/************ funciones para tablas editables *********/
function validate_save(class_label,table_name,server_dir){
	var inputs = $('.'+class_label+' :input');
	var updated = 0;
	for(i=0;i<inputs.length;i++){
		if($(inputs[i]).attr('old_value')!=$(inputs[i]).attr('new_value')){
			console.log('actualizar: '+class_label);
			
			console.log('inputs:'+inputs.length);
			console.log($('.'+class_label+' :input').serialize());
			
			$.post( server_dir + table_name +'/save_edit_table',
				$('.'+class_label+' :input').serialize(), 
				function( data ) {
					console.log(data);
					console.log('ya persistio');
			});

			/* si manda a actualizar, marcar como actualizado y romper el for para no recorrer todos los campos innecesariamente*/
			updated=1;
			break;
		}
	}
	/* si se actualiza el registro, actualizar los oldvalue de esa linea para evitar que se quede pegado */
	if(updated==1){
		for(i=0;i<inputs.length;i++){
			if(updated == 1 && $(inputs[i]).attr('old_value')!=$(inputs[i]).attr('new_value')){
				$(inputs[i]).attr('old_value',$(inputs[i]).attr('new_value'));
			}
		}
	}
}

var old_i = -1;

function editable_switch_off(server_dir,table_name,old_i,i){
	if(!$('.'+table_name+'_field_row_'+i).is(':visible')){
		$('.'+table_name+'_field_row').hide();
		$('.'+table_name+'_label_row').show();
		console.log('calling save validation');
		validate_save(table_name+'_row_'+old_i,table_name,server_dir);
	}
}

function editable_switch_on(server_dir,table_name,i){
	if(old_i == -1)
		old_i = i;
	editable_switch_off(server_dir,table_name,old_i,i);
	old_i = i;
	$('.'+table_name+'_label_row_'+i).hide();
	$('.'+table_name+'_field_row_'+i).show();
}

function update_label(class_label,value,e){
	$('.'+class_label).html(value);
	e.attr('new_value',value);
	//console.log('old_value: '+e.attr('old_value')+' | new_value: '+e.attr('new_value'));
}

function add_row(server_dir,table_name){
	var tope = $('#'+table_name+'_rows').val();
	console.log('tope: '+tope);	
	
	var next_id = (parseInt(tope)+1);
	console.log('next_id: '+next_id);

	var $tr =  $('.'+table_name+'_row_'+tope);
	var $clone = $tr.clone();
	
	$clone.find('.tr_index').html(next_id);
	$clone.find(':input').val('');
	
	$clone.find(':text').val('');
	$clone.find('.'+table_name+'_label_row').html('');
	
	$clone.find('.'+table_name+'_label_row_'+tope).each(function(){
		console.log('elemento: '+$(this).attr('field_name'));
		
		console.log('addClass: '+table_name+'_label_row_'+next_id);
		$(this).addClass(table_name+'_label_row_'+next_id);
		console.log('removeClass: '+table_name+'_label_row_'+tope);
		$(this).removeClass(table_name+'_label_row_'+tope);
		
		console.log('addClass: '+table_name+'_'+$(this).attr('field_name')+'_label_row_'+next_id);
		$(this).addClass(table_name+'_'+$(this).attr('field_name')+'_label_row_'+next_id);
		console.log('removeClass: '+table_name+'_'+$(this).attr('field_name')+'_label_row_'+tope);
		$(this).removeClass(table_name+'_'+$(this).attr('field_name')+'_label_row_'+tope);
		
	});
	
	$clone.find('.'+table_name+'_field_row_'+tope).each(function(){
		
		console.log('addClass: '+table_name+'_field_row_'+next_id);
		$(this).addClass(table_name+'_field_row_'+next_id);
		console.log('removeClass: '+table_name+'_field_row_'+tope);
		$(this).removeClass(table_name+'_field_row_'+tope);
		
		$(this).attr('row_index',next_id);
		
		$(this).find(':input').each(function(){
			$(this).attr('onblur','');	
			$(this).blur(function(){
				update_label(table_name+'_'+$(this).attr('name')+ '_label_row_'+next_id,$(this).val(),$(this));
			});
			$(this).attr('onchange','');	
			$(this).change(function(){
				update_label(table_name+'_'+$(this).attr('name')+ '_label_row_'+next_id,$(this).val(),$(this));
			});
			$(this).attr('onkeyup','');	
			$(this).keyup(function(){
				update_label(table_name+'_'+$(this).attr('name')+ '_label_row_'+next_id,$(this).val(),$(this));
			});
		})
		
	});
	
	
	console.log('addClass: '+table_name+'_row_'+next_id);
	$clone.addClass(table_name+'_row_'+next_id);
	console.log('removeClass: '+table_name+'_row_'+tope);
	$clone.removeClass(table_name+'_row_'+tope);
	
	$clone.attr('onclick','');	
	$clone.click(function(){
		editable_switch_on(server_dir,table_name,next_id);
	});
	
	
	$tr.after($clone);
	
	//copy tr, add tr to tbody, increment ids, increment tope
}
/*********** ***********/