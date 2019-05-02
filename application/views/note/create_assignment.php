<?php
function generate_content($controller, $filename = null, $record = null)
{

    $model_note=$controller->model;

	$model_note->hide_form_column('user_id');
    // $model_note->hide_form_column('init_date');
    // $model_note->hide_form_column('finish_date');
    $model_note->hide_form_column('date_approved');
    $model_note->hide_form_column('source_id');
    $model_note->hide_form_column('status_id');
    $model_note->hide_form_column('note_type_id');

    $model_note->add_options_html('performer_id','is_required="true"');
    if(isset($controller->vars['records']))
        $record = $controller->vars['records'];
    $model_note->set_fields_values('group_id',(new Group)->get_select_data_with_params(array('id'=>'in (select a.group_id from affiliate a inner join `user` u on (u.id=a.user_id) where a.user_id='.Session::get('user_id').' and approved=\'Yes\')'))); 

    $form_card=$controller->view->auto_build_form_content($record);
    $form_card = str_replace('m-1 btn btn-secondary','d-none disable', $form_card);
   
    $select_user = generate_select_user();


    $html_result = file_get_contents(__DIR__ . '/create_body.html');
    // $note_card=generate_note_card($this_note);
    // $approved_card=generate_note_approved_table($this_note['id']);

    $html_result = str_replace('{{ FORM }}', CoreUtils::add_new_card($form_card, 'Crear Asignación'), $html_result);
    // $html_result = str_replace('<a id="link_cancel" href="/abx_app/note/index/" class="m-1 btn btn-secondary ">
    //                 <i class="fas fa-times-circle "></i><span> Cancelar </span></a>','', $html_result);
	// $html_result=str_replace('{{ APPROVE_USERS }}',CoreUtils::add_new_card($select_user, 'Users'),$html_result);
    $html_result=str_replace('{{ APPROVE_USERS }}','',$html_result);
    
    $controller->view->add_script_js("

    $('#group_id').on('change', function() {
        group_id = $('#group_id option:selected' ).val();
       
            $.post( '".SERVER_DIR."affiliate/get_user_affiliate',{group_id:group_id}, function( data ) {
                var user_data=JSON.parse(data);
                $('#performer_id').html('').select2();
                $('#performer_id').select2({
                    data:user_data,
                });
         });
      });
    ");


    return $html_result;
}

function generate_select_user(){
    $user_model= new User();

    $users=$user_model->showAllRecords();

    $html='<div class="form-group">
    <select multiple required name="user_approved_id[]" id="user_approved_id" class="form-control select2">';
    foreach($users as $user){
        $html.=' <option value="'.$user['id'].'">'.$user['names'].' '.$user['lastnames'].'</option>';
    }
    $html.='</select>
</div>';
return $html;
}
 