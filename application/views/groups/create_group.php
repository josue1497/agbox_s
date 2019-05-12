<?php
	function generate_content($controller,$filename=null,$record=null){

                    $record['leader_id']=Session::get('user_id'); 
                    
                    $form_group=$controller->view->auto_build_form_content($record,false);
                     
                     $html_result=file_get_contents(__DIR__.'/create_body.html');

                     $select_user = generate_select_user();
                     
                     $html_result=str_replace('{{ FORM_GROUP }}',CoreUtils::add_new_card($form_group,'Group'),$html_result);
                     $html_result=str_replace('profile-img','profile-img-info',$html_result);
                     $html_result=str_replace('{{ AFFILIATES_USERS }}',CoreUtils::add_new_card($select_user,'Miembros'),$html_result);

                     return $html_result;
}
function generate_select_user(){
    $user_model= new User();

    $users=$user_model->showAllRecords();

    $html='<div class="form-group">
    <select multiple is_required="true" name="user_affiliate[]" id="user_affiliate" class="form-control select2">';
    foreach($users as $user){
        $html.=' <option value="'.$user['id'].'">'.$user['names'].' '.$user['lastnames'].'</option>';
    }
    $html.='</select>
</div>';
return $html;
}
?>