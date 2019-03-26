<?php
	function generate_content($controller,$filename=null,$record=null){

            /* cargar perfil del usuario actual */
       //      
		$record = $controller->vars;
              $this_group = $record['record'];
		$group_card = CoreUtils::generate_card($controller->model,
				$controller->auto_build_view('form',$this_group,$this_group),
				'form',$record);

              

		/* grupos a los que esta afiliado el usuario */
		/* afiliaciones */
              $affiliate_model = new Affiliate();
              $user_model = new User();

              $user_model->hide_column('is_visitor');
              $user_model->hide_column('user_level_id');
              $user_model->hide_column('mail');

		$affs = $affiliate_model->showAllRecords(
                     array('group_id' => $this_group['id']));
                     

		$users = array();

		if($affs)
			foreach($affs as $aff){
                            /* grupos a los que esta afiliado */
                            $users[] = $user_model->get_by_id($aff['user_id']);
			}
              // var_dump($users);die;

		$c = new Controller();
		$c->init($user_model);


		$affiliate_card = CoreUtils::generate_card(
				$c->model,
				$c->auto_build_view(
						'list',
						$users,
						null),
				'list',
				null
                     );

              $affiliate_record=Model::get_sql_data("select a.id as 'affiliate_id', 
              u.id 'user_id', a.group_id, concat(u.names,' ',u.lastnames) as 'user_name',
              r.name as 'role'  
              from `affiliate` a inner join `user` u on(a.user_id=u.id) 
              inner join groups g on (g.id=a.group_id)
              inner join group_user_role gur on (gur.group_id=g.id and u.id=gur.user_id)
              inner join `role` r on (r.id=gur.role_id) 
              where a.group_id=? and a.approved='Yes'",array('group_id'=>$this_group['id']));
              
              $table_affilates='<table class="table table-striped table-hover">
                                   <thead class="text-center thead">
                                          <th>#</th>
                                          <th>Miembro</th>
                                          <th>Rol</th>
                                          <th>Accion</th>
                                   </thead>';
              $table_rows='<tbody>';
              $first=true;
              $i=1;
              foreach($affiliate_record as $row){                     
                $table_rows.='<tr><input type="hidden" name="affiliate_id" value="'.$row['affiliate_id'].'">
                            <input type="hidden" name="user_id" value="'.$row['user_id'].'">
                            <input type="hidden" name="group_id" value="'.$row['group_id'].'">
                            <td class="text-center">'.$i++.'</td>
                            <td class="text-center">'.$row['user_name'].'</td>
                            <td class="text-center">'.$row['role'].'</td>
                            <td class="text-center"><button class="btn btn-secondary">Desafiliar</button></td></tr>';
              }
              $table_rows.='</tbody></table>';
              $table_affilates.=$table_rows;


              $note_group="select n.id 'note_id',n.user_id 'user_id', n.title,concat(u.names,' ',u.lastnames) 'names' ,
              s.name as 'status',nt.name 'note_type'
              from note n inner join `user` u on (u.id=n.user_id)
              inner join status s on (s.id=n.status_id)
              inner join note_type nt on (nt.id=n.note_type_id)
              inner join affiliate a on (a.user_id=u.id)
              inner join groups g on (a.group_id=g.id)
              where g.id=?";


              // var_dump($table_affilates); die;
                     $form_group=$controller->auto_build_view('form',$this_group,$this_group);
               
                     $list_affiliate=$c->auto_build_view('index',$users,$users);

                     $tile_affiliate='<div class="d-flex">Affiliate<button class="btn btn-primary ml-auto"><i class="fas fa-plus"></i></button></div>';
                     
                     $html_result=file_get_contents(__DIR__.'/body.html');
                     
                     $html_result=str_replace('{{ FORM_GROUP }}',CoreUtils::add_new_card($form_group,'Group'),$html_result);
                     $html_result=str_replace('profile-img','profile-img-info',$html_result);
                     $html_result=str_replace('{{ AFFILIATES_USERS }}',CoreUtils::add_new_card($table_affilates,$tile_affiliate),$html_result);
                     $html_result=str_replace('{{ NOTES_GROUP }}',CoreUtils::add_new_card( $list_affiliate,'Affiliate'),$html_result);

                     return $html_result;
}
?>