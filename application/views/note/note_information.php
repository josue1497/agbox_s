<?php
function generate_content($controller, $filename = null, $record = null)
{

    $this_note=$controller->vars['record'];

    $html_result = file_get_contents(__DIR__ . '/note_information.html');
    
    $note_card=generate_note_card($this_note);

    $type_assigment = $this_note['note_type_id']===Note_Type::get_assignment_type();
    if(!$type_assigment){
      $approved_card=generate_note_approved_table($this_note['id']);
    }else{
      $approved_card=generate_note_comment_table($this_note['id']);
    }
    

    $html_result = str_replace('{{ NOTE_INFO }}', CoreUtils::add_new_card($note_card, 'Información'), $html_result);
  // $html_result = str_replace('profile-img', 'profile-img-info d-flex justify-content-center', $html_result);
  $type_assigment = $this_note['note_type_id']===Note_Type::get_assignment_type();
	$html_result = str_replace('{{ APPROVE_USERS }}', (CoreUtils::add_new_card($approved_card, ($type_assigment)?'Comentarios':'Aprobadores')), $html_result);
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

    $performer=$user_model->get_by_property(array('id'=>$note['performer_id']));

    $group=(new Group())->get_by_property(array('id'=>$note['group_id']));

    $status=(new Status())->get_by_property(array('id'=>$note['status_id']));

    $html='
    <div class="card-body">
      <h5 class="card-title text-center display-4 text-primary">'.$note['title'].'</h5>
      <h6 class="card-subtitle mb-2 text-muted text-center">'.$note['summary'].'</h6>
        <hr>    
      <p class="card-text"><b>Grupo: </b> '.$group['name'].'</p>
      <p class="card-text"><b>Tipo de Nota: </b> '.$type['name'].'</p>
      <p class="card-text"><b>Estado: </b> '.$status['name'].'</p>
      <p class="card-text"><b>Creador: </b> '.$user['names'].' '.$user['lastnames'].'</p>';
      '<p class="card-text"><b>Asignado a: </b> '.((Session::get('user_id')==$performer['id'])?'Mí':($performer['names'].' '.$performer['lastnames'])).'</p>';
      
      if($note['note_type_id']==Note_Type::get_assignment_type()){
        $html.='<p class="card-text"><b>Asignado a: </b> '.((Session::get('user_id')==$performer['id'])?'Mí':($performer['names'].' '.$performer['lastnames'])).'</p>
        <div class="d-flex justify-content-center">
          <div class="d-flex flex-column">
            <div class="text-center my-0"><b>Fechas:</b></div>
            <p class=""><b>Desde: </b>'.strftime ( "%d %b %G" , strtotime($note['init_date'])).'&nbsp -&nbsp;
                        <b>Hasta: </b>'.strftime ( "%d %b %G" , strtotime($note['finish_date'])).'
            </p>
          </div>
      </div>';
      }
      
  $html.='</div>';
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

function generate_note_comment_table($note_id){
  $note_group=Model::get_sql_data("SELECT nc.note_id ,concat(u.names,' ',u.lastnames) as 'user_names', nc.date_comment, nc.comment 
  from note_comment nc inner join `user` u on (u.id=nc.author_id) 
  where note_id=? order by nc.date_comment desc",array('note_id'=>$note_id));


	$table_notes='<table class="table table-striped table-hover w-100 display responsive data-table">
	<thead class="text-center thead">
       <th>#</th>
       <th>Miembro</th>
		   <th>Fecha</th>
	</thead>';
	$table_note_rows='<tbody>';
  $i=1;
  setlocale(LC_ALL,"es_ES");  
	foreach($note_group as $row){                     
  $table_note_rows.='<tr data-toggle="popover"  data-trigger="hover" title="'.strftime ( "%d %b %G %H:%M" , strtotime($row['date_comment'])).'"
   data-content="'.$row['comment'].'"><input type="hidden" name="note_id" value="'.$row['note_id'].'">
  <td class="text-center">'.$i++.'</td>
  <td class="text-center">'.$row['user_names'].'</td>
	<td class="text-center">'.strftime ( "%d %b %G" , strtotime($row['date_comment'])).'</td>';
	}
	$table_note_rows.='</tbody></table>';
	$table_notes.=$table_note_rows;
		   
	return $table_notes;
}