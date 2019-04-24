<?php
function generate_content($controller, $filename = null, $record = null)
{

    $model_note=$controller->model;

	$model_note->hide_form_column('user_id');
    // $model_note->hide_form_column('init_date');
    // $model_note->hide_form_column('finish_date');
    $model_note->hide_form_column('date_approved');
    $model_note->hide_form_column('status_id');
    $model_note->hide_form_column('note_type_id');
    if(isset($controller->vars['records']))
        $record = $controller->vars['records'];

    $form_card=$controller->view->auto_build_form_content($record);
    $form_card = str_replace('m-1 btn btn-secondary','d-none disable', $form_card);
   
    $select_user = generate_select_user();


    $html_result = file_get_contents(__DIR__ . '/create_body.html');
    // $note_card=generate_note_card($this_note);
    // $approved_card=generate_note_approved_table($this_note['id']);

    $html_result = str_replace('{{ FORM }}', CoreUtils::add_new_card($form_card, 'Assingment'), $html_result);
    // $html_result = str_replace('<a id="link_cancel" href="/abx_app/note/index/" class="m-1 btn btn-secondary ">
    //                 <i class="fas fa-times-circle "></i><span> Cancelar </span></a>','', $html_result);
	$html_result=str_replace('{{ APPROVE_USERS }}',CoreUtils::add_new_card($select_user, 'Users'),$html_result);

    return $html_result;
}

function generate_select_user(){
    $user_model= new User();

    $users=$user_model->showAllRecords();

    $html='<div class="form-group">
    <select multiple required name="user_approved_id" id="user_approved_id" class="form-control select2">';
    foreach($users as $user){
        $html.=' <option value="'.$user['id'].'">'.$user['names'].' '.$user['lastnames'].'</option>';
    }
    $html.='</select>
</div>';
return $html;
}
 