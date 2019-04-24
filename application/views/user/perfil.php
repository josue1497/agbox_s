<?php
function generate_content($controller, $filename = null, $record = null)
{
	//$this->init(new User()); already loaded in userController/perfil

	/* cargar perfil del usuario actual */
	$record = $controller->model->get_by_id(Session::get('user_id'));
	$user_moel=$controller->model;
	$user_moel->hide_form_column('user_level_id');
	$user_moel->hide_form_column('is_visitor');
	

	$user_card = $controller->auto_build_view('form', null, $record);
	

	/* grupos a los que esta afiliado el usuario */
	/* afiliaciones */
	$affiliate_model = new Affiliate();
	$group_model = new Group();

	$affs = $affiliate_model->showAllRecords(
		array('user_id' => Session::get('user_id'))
	);


	$groups = array();

	if ($affs)
		foreach ($affs as $aff) {
			/* grupos a los que esta afiliado */
			$groups[] = $group_model->showAllRecords(array('id' => $aff['group_id']));
		}


	$c = new Controller();
	$c->init($group_model);

	
	$groups_card = generate_affiliate_table(Session::get('user_id'));
	
	
	/* notes of user */
	$note_model = new Note();
	$approver_model = new Note_Approver();
	$notes = array();

	/* approved or rejected notes for this user */
	$approvers =
		$approver_model->showAllRecords(array('user_id' => Session::get('user_id')));
	/* if eists */
	if ($approvers)
		foreach ($approvers as $approver) {
			/* map it */
			$notes[] = $note_model->showAllRecords(array('id' => $approver['note_id']));
		}

	/* buid view for this component */
	$n = new Controller();
	$n->init($note_model);

	$notes_card = generate_note_table(Session::get('user_id'));
	

	/* update class */

	$html_result = file_get_contents(__DIR__ . '/perfil_body.html');

	$user_card = str_replace('container', '', $user_card);
	$groups_card = str_replace('container', '', $groups_card);

	$tile_affiliate='<div class="d-flex">Groups
		<button class="btn btn-primary ml-auto" id="add_affiliate" onclick="location.href=\''.CoreUtils::base_url().'affiliate/items/'.Session::get('user_id').'\'"><i class="fas fa-plus"></i></button></div>';

		$button_add_note='<div class="btn-group dropleft ml-auto">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			   <i class="fas fa-plus"></i>
		</button>
		<div class="dropdown-menu">
		<a class="dropdown-item" href="'.SERVER_DIR.'note/create_assignment">Asignacion</a>
		<a class="dropdown-item" href="'.SERVER_DIR.'note/create_suggested_point">Punto Sugerido</a>
		<a class="dropdown-item" href="'.SERVER_DIR.'note/create_commitment">Comentario</a>
		<a class="dropdown-item" href="'.SERVER_DIR.'note/create_agenda_point">Punto de Agenda</a>
		</div>
	  </div>';
	$title_note='<div class="d-flex">User´s Notes'.$button_add_note.'</div>';
			 
	

	// $user_card = str_replace('col-md-12 col-md-offset-2', 'col-lg-6 mb-4', $user_card);
	// $groups_card = str_replace('col-md-12 col-md-offset-2', 'col-lg-6 mb-4', $groups_card);
	$html_result = str_replace('{{ USER_CARD }}', CoreUtils::add_new_card($user_card, 'User information '), $html_result);
	$html_result = str_replace('profile-img', 'profile-img-info d-flex justify-content-center', $html_result);
	$html_result = str_replace('{{ GROUPS_CARD }}', CoreUtils::add_new_card($groups_card, $tile_affiliate), $html_result);
	$html_result = str_replace('{{ NOTES_USER }}', CoreUtils::add_new_card($notes_card, $title_note), $html_result);

	
	$controller->view->add_script_js('function desafiliar(user_id,group_id,role_id,affiliate_id){
		$.post("'.SERVER_DIR.'user/unaffiliate",
			{"user_id":user_id,"group_id":group_id,"role_id":role_id,"affiliate_id":affiliate_id},
			function(data){
				/* cargar response */
				$(".group_result").html(data);
		});}');

	/* return view with 3 cards */
	return $html_result;

	/*
*/
}

function generate_note_table($user_id){
	$note_group=Model::get_sql_data("select n.id 'note_id',n.user_id 'user_id',g.id 'group_id', n.title,
	g.name 'group_name' , s.name as 'status',nt.name 'note_type'
	from note n inner join status s on (s.id=n.status_id)
	inner join note_type nt on (nt.id=n.note_type_id)
	inner join `user` u on (u.id=n.user_id)
	inner join groups g on (n.group_id=g.id)
	where u.id=?",array('user_id'=>$user_id));

	$table_notes='<table class="table table-striped table-hover w-100 display responsive data-table">
	<thead class="text-center thead">
		   <th>#</th>
		   <th>Titulo</th>
		   <th>Grupo</th>
		   <th>Tipo</th>
	</thead>';
	$table_note_rows='<tbody>';
	$i=1;
	foreach($note_group as $row){                     
	$table_note_rows.='<tr onclick="location.href=\''.SERVER_DIR.'note/note_information/'.$row['note_id'].'\'"><input type="hidden" name="note_id" value="'.$row['note_id'].'">
	<input type="hidden" name="user_id" value="'.$row['user_id'].'">
	<input type="hidden" name="group_id" value="'.$row['group_id'].'">
	<td class="text-center">'.$i++.'</td>
	<td class="text-center">'.$row['title'].'</td>
	<td class="text-center">'.$row['group_name'].'</td>
	<td class="text-center">'.$row['note_type'].'</td>
	</tr>';
	}
	$table_note_rows.='</tbody></table>';
	$table_notes.=$table_note_rows;
		   
	return $table_notes;
}

function generate_affiliate_table($user_id){
	$affiliate_record=Model::get_sql_data("select a.id as 'affiliate_id', 
	u.id 'user_id', a.group_id, g.name as 'group_name',
	r.name as 'role' , r.id as role_id 
	from `affiliate` a inner join `user` u on(a.user_id=u.id) 
	inner join groups g on (g.id=a.group_id)
	inner join group_user_role gur on (gur.group_id=g.id and u.id=gur.user_id)
	inner join `role` r on (r.id=gur.role_id) 
	where a.user_id=? and a.approved='Yes'",array('user_id'=>$user_id));
	
	$table_affilates='<table class="table table-striped table-hover w-100 display responsive data-table">
						 <thead class="text-center thead">
								<th>#</th>
								<th>Grupo</th>
								<th>Rol</th>
								<th>Accion</th>
						 </thead>';
	$table_rows='<tbody>';
	$i=1;
	foreach($affiliate_record as $row){                     
	  $table_rows.='<tr id="aff_'.$row['affiliate_id'].'""><input type="hidden" name="affiliate_id" value="'.$row['affiliate_id'].'">
				  <input type="hidden" name="user_id" value="'.$row['user_id'].'">
				  <input type="hidden" name="group_id" value="'.$row['group_id'].'">
				  <td class="text-center">'.$i++.'</td>
				  <td class="text-center">'.$row['group_name'].'</td>
				  <td class="text-center">'.$row['role'].'</td>
				  <td class="text-center"><button class="btn btn-secondary" 
				  onclick="desafiliar(\''.$row['user_id'].'\',\''.$row['group_id'].'\','.
				  	'\''.$row['role_id'].'\',\''.$row['affiliate_id'].'\')"
				   >Desafiliar</button></td></tr>';
	}
	$table_rows.='</tbody></table><span class="group_result"></span>';
	$table_affilates.=$table_rows;

	return $table_affilates;
}
 