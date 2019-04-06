<?php
	function generate_content($controller,$filename=null,$record=null){

            /* cargar perfil del usuario actual */
       //      
		$record = $controller->vars;
              $this_group = $record['record'];

		/* grupos a los que esta afiliado el usuario */
		/* afiliaciones */
              $affiliate_model = new Affiliate();
              $user_model = new User();

              $user_model->hide_grid_column('is_visitor');
              $user_model->hide_grid_column('user_level_id');
              $user_model->hide_grid_column('mail');

		$affs = $affiliate_model->showAllRecords(
                     array('group_id' => $this_group['id']));
                     

		$users = array();

		if($affs)
			foreach($affs as $aff){
                            /* grupos a los que esta afiliado */
                            $users[] = $user_model->get_by_id($aff['user_id']);
			}

		$c = new Controller();
		$c->init($user_model);

             
              $table_affilates=generate_affiliate_table($this_group['id']);

              
              $table_notes=generate_note_table($this_group['id']);

                     $form_group=$controller->auto_build_view('form',$this_group,$this_group);

                     $tile_affiliate='<div class="d-flex">Affiliate<button class="btn btn-primary ml-auto" id="add_affiliate"><i class="fas fa-plus"></i></button></div>';
                     $title_note='<div class="d-flex">Group´s Notes<button class="btn btn-primary ml-auto" id="add_note"><i class="fas fa-plus"></i></button></div>';
                     
                     $html_result=file_get_contents(__DIR__.'/body.html');
                     
                     $html_result=str_replace('{{ FORM_GROUP }}',CoreUtils::add_new_card($form_group,'Group'),$html_result);
                     $html_result=str_replace('profile-img','profile-img-info',$html_result);
                     $html_result=str_replace('{{ AFFILIATES_USERS }}',CoreUtils::add_new_card($table_affilates,$tile_affiliate),$html_result);
                     $html_result=str_replace('{{ NOTES_GROUP }}',CoreUtils::add_new_card( $table_notes,$title_note),$html_result);
                     $html_result=str_replace('{{ ROLE_USER }}',generate_role_user(),$html_result);
                     


                     $controller->view->add_script_js("$('#modal-user').on('show.bs.modal', function (event) {
                            var button = $(event.relatedTarget) // Button that triggered the modal
                            var name = button.data('user')
                            var group = button.data('group') ;// Extract info from data-* attributes
                            var id = button.data('id');
                            var role = button.data('role');
                            var affiliate = button.data('affiliate');

                            var modal = $(this)
                            var text=modal.find('.modal-title').text();

                            modal.find('.modal-title').text('Cambiar Rol a ' + name);
                            modal.find('#user-name').val(name);
                            modal.find('#user-id').val(id);
                            modal.find('#group-id').val(group);
                            modal.find('#affiliate-id').val(affiliate);
                            modal.find('#group_user_role').val(role);
                          });
                          
                          $('#save-button').click(function(){

                            var role = $('#group_user_role option:selected').text();
                            $.post( '".SERVER_DIR."group_user_role/update_group_user_role',$('#form-user').serialize(), function( data ) {
                                   
                                   console.log(data);
                                   if(''!==data && 'fail'!==data){
                                       $('#role'+data).text(role);
                                       $('#modal-user').modal('hide');
                                   }else{
                                      alert('fail');   
                                      $('#modal-user').modal('hide'); 
                                   }
                                 });
                          });

                          $('#desaffiliate-button').click(function(){
                            if(confirm('¿Esta seguro que desea Desafiliar este usuario?')){
                            $.post( '".SERVER_DIR."group_user_role/desaffiliate_group_user_role',$('#form-user').serialize(), function( data ) {
                                   
                                   console.log(data);
                                   if(''!==data && 'fail'!==data){
                                       $('#'+data).remove();
                                       $('#modal-user').modal('hide');
                                   }else{
                                      alert('fail');  
                                      $('#modal-user').modal('hide');  
                                   }
                                 });
                            }
                          });

                          ");

                     return $html_result;
}

function generate_affiliate_table($group_id){
       $affiliate_record=Model::get_sql_data("select a.id as 'affiliate_id', 
       u.id 'user_id', a.group_id, concat(u.names,' ',u.lastnames) as 'user_name',
       r.name as 'role', r.id  as 'role_id'  
       from `affiliate` a inner join `user` u on(a.user_id=u.id) 
       inner join groups g on (g.id=a.group_id)
       inner join group_user_role gur on (gur.group_id=g.id and u.id=gur.user_id)
       inner join `role` r on (r.id=gur.role_id) 
       where a.group_id=? and a.approved='Yes'",array('group_id'=>$group_id));
       
       $table_affilates='<table class="table table-striped table-hover">
                            <thead class="text-center thead">
                                   <th>#</th>
                                   <th>Miembro</th>
                                   <th>Rol</th>
                            </thead>';
       $table_rows='<tbody>';
       $i=1;
       foreach($affiliate_record as $row){                     
         $table_rows.='<tr data-toggle="modal" data-target="#modal-user" 
                            data-user="'.$row['user_name'].'" data-group="'.$row['group_id'].'"
                            data-role="'.$row['role_id'].'" data-id="'.$row['user_id'].'"
                            data-affiliate="'.$row['affiliate_id'].'" id="'.$row['affiliate_id'].'">
                     <input type="hidden" name="affiliate_id" value="'.$row['affiliate_id'].'">
                     <input type="hidden" name="user_id" value="'.$row['user_id'].'">
                     <input type="hidden" name="group_id" value="'.$row['group_id'].'">
                     <td class="text-center">'.$i++.'</td>
                     <td class="text-center">'.$row['user_name'].'</td>
                     <td class="text-center" id="role'.$row['affiliate_id'].'">'.$row['role'].'</td>
                     </tr>';
       }
       $table_rows.='</tbody></table>';
       $table_affilates.=$table_rows;

       return $table_affilates;
}

function generate_note_table($group_id){
       $note_group=Model::get_sql_data("select n.id 'note_id',n.user_id 'user_id',g.id 'group_id', n.title,
       concat(u.names,' ',u.lastnames) 'names' , s.name as 'status',nt.name 'note_type'
       from note n inner join status s on (s.id=n.status_id)
       inner join note_type nt on (nt.id=n.note_type_id)
       inner join `user` u on (u.id=n.user_id)
       inner join groups g on (n.group_id=g.id)
       where g.id=?",array('group_id'=>$group_id));

       $table_notes='<table class="table table-striped table-hover">
       <thead class="text-center thead">
              <th>#</th>
              <th>Titulo</th>
              <th>Usuario Asignado</th>
              <th>Tipo</th>
              <th>Accion</th>
       </thead>';
       $table_note_rows='<tbody>';
       $i=1;
       foreach($note_group as $row){                     
       $table_note_rows.='<tr><input type="hidden" name="note_id" value="'.$row['note_id'].'">
       <input type="hidden" name="user_id" value="'.$row['user_id'].'">
       <input type="hidden" name="group_id" value="'.$row['group_id'].'">
       <td class="text-center">'.$i++.'</td>
       <td class="text-center">'.$row['title'].'</td>
       <td class="text-center">'.$row['names'].'</td>
       <td class="text-center">'.$row['note_type'].'</td>
       <td class="text-center"><button class="btn btn-secondary">Datalles</button></td></tr>';
       }
       $table_note_rows.='</tbody></table>';
       $table_notes.=$table_note_rows;
              
       return $table_notes;
}

function generate_role_user(){
	$role = new Role();
	$all_roles=$role->showAllRecords();
	$html='<div class="form-group">
				<label for="group_user_role" class="">Role in the Group</label>
			<select name="group_user_role" id="group_user_role" class="form-control">
				<option value="">Select a value</option>';
			foreach($all_roles as $rol){
				$html.='<option value="'.$rol['id'].'">'.$rol['name'].'</option>';
			}
	$html.='</select></div>';
	return $html;
} 
?>