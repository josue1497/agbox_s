<?php
	function generate_content($controller,$filename=null,$record=null){

                    $record['leader_id']=Session::get('user_id'); 
                    
                    $form_group=$controller->view->auto_build_form_content($record,false);
                    // $form_group=$controller->auto_build_view('form',$record,$record);

                    //  Session::set('group_id',$this_group['id']);

                    //  $tile_affiliate='<div class="d-flex">Affiliate<button class="btn btn-primary ml-auto" id="add_affiliate"
                    //  data-toggle="modal" data-target="#modal-affiliate"><i class="fas fa-plus"></i></button></div>';
                    //  $title_note='<div class="d-flex">Group´s Notes'.$button_add_note.'</div>';
                     
                     $html_result=file_get_contents(__DIR__.'/create_body.html');

                     $select_user = generate_select_user();
                     
                     $html_result=str_replace('{{ FORM_GROUP }}',CoreUtils::add_new_card($form_group,'Group'),$html_result);
                     $html_result=str_replace('profile-img','profile-img-info',$html_result);
                     $html_result=str_replace('{{ AFFILIATES_USERS }}',CoreUtils::add_new_card($select_user,'Miembros'),$html_result);

                     $controller->view->add_script_js("
                          $('#save-group-button').click(function(){

                            // alert($('#form-group').serialize());
                            $.post( '".SERVER_DIR."groups/create_group',
                            $('#form-group').serialize(), function( data ) {
                                   
                                   console.log(data);
                            //        if(''!==data && 'fail'!==data){
                            //            $('#role'+data).text(role);
                            //            $('#modal-user').modal('hide');
                            //        }else{
                            //           alert('fail');   
                            //           $('#modal-user').modal('hide'); 
                            //        }
                                 });
                          });
                           ");

                     return $html_result;
}
function generate_select_user(){
    $user_model= new User();

    $users=$user_model->showAllRecords();

    $html='<div class="form-group">
    <select multiple required name="user_affiliate[]" id="user_affiliate" class="form-control select2">';
    foreach($users as $user){
        $html.=' <option value="'.$user['id'].'">'.$user['names'].' '.$user['lastnames'].'</option>';
    }
    $html.='</select>
</div>';
return $html;
}
?>