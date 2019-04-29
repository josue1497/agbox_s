<?php
function generate_content($controller, $filename = null, $record = null)
{

    $this_note=$controller->vars['record'];

    $html_result = file_get_contents(__DIR__ . '/note_information.html');
    $note_card=generate_note_card($this_note);
    $approved_card=generate_note_approved_table($this_note['id']);

    $html_result = str_replace('{{ NOTE_INFO }}', CoreUtils::add_new_card($note_card, 'Información'), $html_result);
  // $html_result = str_replace('profile-img', 'profile-img-info d-flex justify-content-center', $html_result);
  $type_assigment = $this_note['note_type_id']===Note_Type::get_assignment_type();
	$html_result = str_replace('{{ APPROVE_USERS }}', (!$type_assigment ? CoreUtils::add_new_card($approved_card, 'Aprobadores'):''), $html_result);
	// $html_result=str_replace('{{ APPROVE_BUTTON }}',generate_button_approve($this_note['id'], Session::get('user_id')),$html_result);

    return $html_result;
}

function generate_note_card($note){

    $note_type_model = new Note_Type();
    $type=$note_type_model->get_by_property(array('id'=>$note['note_type_id']));

    $source_model = new Source();
    $source=$source_model->get_by_property(array('id'=>$note['source_id']));

    $user_model = new User();
    $user=$user_model->get_by_property(array('id'=>$note['user_id']));

    $html='
    <div class="card-body">
      <h5 class="card-title text-center display-4 text-info">'.$note['title'].'</h5>
      <h6 class="card-subtitle mb-2 text-muted">'.$note['summary'].'</h6>
        <hr>    
      <p class="card-text"><b>Origen: </b> '.$source['title'].'</p>
      <p class="card-text"><b>Tipo de Nota: </b> '.$type['name'].'</p>
      <p class="card-text"><b>Creador: </b> '.$user['names'].' '.$user['lastnames'].'</p>
      <div class="d-flex justify-content-end">
        <a href="#" class="btn btn-primary">Detalles</a>
      </div>
      
  </div>';
  return $html;
}

function generate_note_approved_table($note_id){
	$note_group=Model::get_sql_data("SELECT u.id 'user_id', n.id 'note_id', na.id 'approver_id', 
    concat(u.names,' ',u.lastnames) as 'user_names', na.choice 
    from note_approver na inner JOIN note n on (n.id=na.note_id) 
    inner join `user` u on (u.id=na.user_id)
    where na.note_id=?",array('note_id'=>$note_id));


	$table_notes='<table class="table table-striped table-hover w-100 display responsive data-table">
	<thead class="text-center thead">
		   <th>#</th>
		   <th>Miembro</th>
		   <th>Eleccion</th>
	</thead>';
	$table_note_rows='<tbody>';
	$i=1;
	foreach($note_group as $row){                     
	$table_note_rows.='<tr><input type="hidden" name="note_id" value="'.$row['note_id'].'">
	<input type="hidden" name="user_id" value="'.$row['user_id'].'">
	<input type="hidden" name="approver_id" value="'.$row['approver_id'].'">
	<td class="text-center">'.$i++.'</td>
	<td class="text-center">'.$row['user_names'].'</td>
	<td class="text-center">'.$row['choice'].'</td>';
	}
	$table_note_rows.='</tbody></table>';
	$table_notes.=$table_note_rows;
		   
	return $table_notes;
}

 