<?php
function generate_content($controller, $filename = null, $record = null)
{

    $this_note=$controller->vars['record'];

    $html_result = file_get_contents(__DIR__ . '/note_information.html');

    Affiliate::is_leader($this_note['group_id'],Session::get('user_id'));    

    $note_card=generate_note_card($this_note);
    $approved_card=generate_note_comment_table($this_note['id']);

    $html_result = str_replace('{{ NOTE_INFO }}', CoreUtils::add_new_card($note_card, 'Note information '), $html_result);
	// $html_result = str_replace('profile-img', 'profile-img-info d-flex justify-content-center', $html_result);
	$html_result = str_replace('{{ APPROVE_USERS }}', CoreUtils::add_new_card($approved_card, 'Comentarios'), $html_result);
	// $html_result=str_replace('{{ APPROVE_BUTTON }}',generate_button_approve($this_note['id'], Session::get('user_id')),$html_result);

    return $html_result;
}

function generate_note_card($note){

    $note_type_model = new Note_Type();
    $type=$note_type_model->get_by_property(array('id'=>$note['note_type_id']));

    $source_model = new Source();
    $source=$source_model->get_by_property(array('id'=>$note['source_id']));

    $user_model = new User();
    $user=$user_model->get_by_property(array('id'=>$note['performer_id']));
    $html='
    <div class="card-body">
    <div  style="background:transparent !important" class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4 card-title text-center">'.$note['title'].'</h1>
          <p class="lead text-center">'.$note['summary'].'</p>
          <p class="card-text lead text-center"><span class="font-weight-bold">Responsable: </span> '.$user['names'].' '.$user['lastnames'].'</p>
        </div>
    </div>
      
      <div class="d-flex justify-content-center">
        <button href="#" class="btn btn-success mx-2">Cerrar</button>
        <button href="#" class="btn btn-danger mx-2">Reasignar</button>
      </div>
      
  </div>';
  return $html;
}

function generate_note_comment_table($note_id){
  $note_group=Model::get_sql_data("SELECT nc.note_id ,concat(u.names,' ',u.lastnames) as 'user_names', nc.date_comment, nc.comment 
  from note_comment nc inner join `user` u on (u.id=nc.author_id) 
  where note_id=? order by date_comment desc",array('note_id'=>$note_id));


	$table_notes='<table class="table table-striped table-hover w-100 display responsive data-table">
	<thead class="text-center thead">
       <th>#</th>
       <th>Miembro</th>
		   <th>Comentario</th>
		   <th>Fecha</th>
	</thead>';
	$table_note_rows='<tbody>';
  $i=1;
  setlocale(LC_ALL,"es_ES");  
	foreach($note_group as $row){                     
	$table_note_rows.='<tr><input type="hidden" name="note_id" value="'.$row['note_id'].'">
  <td class="text-center">'.$i++.'</td>
  <td class="text-center">'.$row['user_names'].'</td>
	<td class="text-center">'.$row['comment'].'</td>
	<td class="text-center">'.strftime ( "%d %b %g %H:%M" , strtotime($row['date_comment'])).'</td>';
	}
	$table_note_rows.='</tbody></table>';
	$table_notes.=$table_note_rows;
		   
	return $table_notes;
}

 