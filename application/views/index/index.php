<?php

function generate_content($controller, $filename = null, $record = null){

  $sql_groups =
    "select gur.group_id,g.name,g.group_photo,g.description
		from groups g 
		inner join affiliate gur on g.id=gur.group_id 
    where gur.user_id=? and gur.approved='Yes'";

  $list = Model::get_sql_data($sql_groups, array('user_id' => Session::get('user_id')));
  $list_html = "";

   $controller->view->add_script_js("
   		function show_for(item){
   			if(item == 0){
  				$('.group_note').show();
  				$('.ver_todo').hide();
  			}else{
  				$('.group_note').hide();
  				$('.group_note_'+item).show();
  				$('.ver_todo').show();
  			}
  		}");

  foreach ($list as $map) {
    $photo = $map['group_photo'] ? Component::img_to_base64(UPLOADS_DIR . $map['group_photo']) : Component::img_to_base64(IMG_DIR.'image-group.png');
    $list_html .= '
		<div class="col-3">
            <div class="card bg-transparent border-0">
              <div class="d-flex flex-column">
              <div class="d-flex justify-content-center">
                <div class="d-flex align-items-center">
                <!-- ancla -->
                  <a class="text-decoration-none" href="javascript:show_for(' . $map['group_id'] . ')">
                     <i class="fas fa-2x text-gray-300"><img class="img-profile rounded-circle img-profile-user" src="' . $photo . '"></i>&nbsp;&nbsp;</a>
                  <a href="#" data-toggle="modal" data-target="#group_info_modal" data-group-name="' . $map['name'] . '"
                  data-group-id="' . $map['group_id'] . '" data-group-desc="' . $map['description'] . '" ><i class="fas fa-ellipsis-v text-secondary" '.Component::set_tooltip_info("información rápida").'></i></a>
                </div>
              </div>
              <!-- ancla -->
              <a class="text-decoration-none" href="javascript:show_for(' . $map['group_id'] . ')">
                <div class="d-flex justify-content-center">
                  <div class="mt-1 w-100">
                    <div class="h6 mb-0 font-weight-bold text-gray-800 mw-100"  '.Component::set_tooltip_info($map['name']).'><p class="h6 text-center text-truncate">' . $map['name'] . '</p></div>
                  </div>
                </div>
                </a>
              </div>
            </div>
          </div>';
  }


  $pendientes = get_pending_notes($list);
  if(empty($pendientes)){
    $pendientes='<div class="p-3 h3 text-center text-info">No posee asignaciones Pendientes</div>';
  }

  $completadas = get_completed_notes($list);
  if(empty($completadas)){
    $completadas='<div class="p-3 h3 text-center text-info">No posee asignaciones Completadas</div>';
  }

  $cerradas = get_closed_notes($list);
  if(empty($cerradas)){
    $cerradas='<div class="p-3 h3 text-center text-info">No posee asignaciones cerradas</div>';
  }


  $html_result = file_get_contents(__DIR__ . '/index.html');

  $html_result = str_replace('{{ groups_horizontal_list }}', $list_html, $html_result);

  $html_result = str_replace('{{ PENDINGS_NOTES }}', CoreUtils::add_new_card($pendientes, 'Pendientes  <a class="ver_todo text-secondary" style="display:none;" href="javascript:show_for(0)" >(ver todo)</a>'), $html_result);

  $html_result = str_replace('{{ completed_notes }}', CoreUtils::add_new_card($completadas, 'Completadas  <a  class="ver_todo text-secondary" style="display:none;" href="javascript:show_for(0)" >(ver todo)</a>'), $html_result);

  $html_result = str_replace('{{ closed_notes }}', CoreUtils::add_new_card($cerradas, 
  	'Cerradas  <a  class="ver_todo text-secondary" style="display:none;" href="javascript:show_for(0)" >(ver todo)</a>'), $html_result);
 
    $html_result = str_replace('{{ menu_icons }}', build_icons(Session::get('user_id')), $html_result);

  return $html_result;
}

/**
 * metodo para obtener las notas pendientes del usuario actual 
 * en sus gruos afiliados
 * @param type $list_group 
 * @return type
 */
function get_pending_notes($list_group){
	return get_notes($list_group,'P');
}

function get_completed_notes($list_group){
	return get_notes($list_group,'CO');
}

function get_closed_notes($list_group){
	return get_notes($list_group,'C');
}

/**
 * metodo para obtener las notas del usuario actual segun los grupos en 
 * los que este afiliado
 * @param type $list_group 
 * @param type $note_status 
 * @return type
 */
function get_notes($list_group,$pending){
  $function_result = '';
  $note_model = new Note();
  $user_id = Session::get('user_id');
  foreach ($list_group as $group) {
    $query="select n.id ,n.title, n.finish_date, n.group_id , n.summary,
    g.name from note n 
    inner join note_type nt on (nt.id=n.note_type_id)
    inner join status s on (s.id=n.status_id)
    inner join `user` u on (n.performer_id=u.id)
    inner join groups g on (g.id=n.group_id)
    where n.performer_id=" . $user_id . " and g.id=" . $group['group_id'] .
    " and s.value='".$pending."' and nt.value='AS'
    order by n.finish_date";

    $note_list = Model::get_sql_data($query);
    if (!empty($note_list)) {
      $function_result .= build_groups($group, $note_list,$pending);
    }else{

    }
  }

  return $function_result;
}

function build_groups($group, $list, $pending=false){
  $result = '<div class="row my-2 group_note group_note_'.$group['group_id'].'">
  <div class="col-12">
    <div class="row">
      <div class="col-6 d-flex justify-content-center">
        <a href="' . SERVER_DIR . 'groups/group_information/' . $group['group_id'] . '" class="text-decoration-none">
          <div class="w-100">
            <h3 class="text-mutted ml-2 text-truncate">' . $group['name'] . '</h3>
          </div>  
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex flex-column">
        <ul class="list-group"  id="' . $group['group_id'] . '">
         ' . build_line($list,$group['group_id'],$pending) . '
        </ul>
      </div>
    </div>
  </div>
</div>';
  return $result;
}

function build_line($list_lines, $group_id,$pending){
  $result = '';
  
  setlocale(LC_ALL,"es_ES");
  foreach ($list_lines as $line) {
    $result .= '<li class="list-group-item list-group-item-action border-0" id="'.$line['id'].'">
                <div class="d-flex ">
                    <div class="p-2" data-toggle="modal" data-target="#'.
                    (build_buttons($pending)?'':'completed-').
                    'note-info-modal" data-note="'. $line['id'].'" 
                    data-title="'. $line['title'].'"  data-summary="'. $line['summary'].'"
                    data-group="'. $group_id.'" >' . $line['title'] . '</div>
                    <div class="p-2"><small><b>' . @strftime ( "%d %b %g" , @strtotime($line['finish_date'])) . '</b></small></div>
                    <div class="ml-auto p-2">
                        <div class="d-flex flex-row">
                            <div class="mx-2" >
                              '.(build_buttons($pending)?'<a  data-toggle="modal" data-target="#add-comment-modal" data-note="'. $line['id'].'" 
                                   data-title="'. $line['title'].'" data-author="'.Session::get('user_id').'" >
                                  <i class="fas fa-comments fa-lg text-secondary" '.Component::set_tooltip_info("Añadir comentario de Avance").'></i>
                              </a>':'').'
                            </div>
                        </div>
                    </div>
              </div>
            </li>';
  }

  return $result;
}

function build_buttons($status){

  return Status::get_status_id($status)==Status::get_pending_status();

}

function build_icons ($user_id){

  $query = 'select m.* from menu m inner join item_index_page ip on (ip.menu_id=m.menu_id)
  where ip.user_id=?';

  $icons = Model::get_sql_data($query, array('user_id'=>$user_id));

  $html='';
  foreach($icons as $icon){
    $html.='<div class="col-6">
    <div class="card bg-transparent border-0">
      <div class="d-flex flex-column">
        <div class="d-flex justify-content-center">
          <div class="d-flex align-items-center justify-content-center">
            <!-- ancla -->
            <a class="text-decoration-none" href="'.SERVER_DIR.$icon['url'].'"
              tabindex="0">
              <div class="icon-circle-index bg-info d-flex align-items-center justify-content-center ">
              <div><i class="'.$icon['icon'].' text-white fa-2x"></i></div>
                  </div>
              <h6 class="text-center my-1 text-secondary">'.$icon['title'].'</h6>
            </a>
          </div>
        </div>
      </div>
    </div>
</div>';
  }

 


  return $html;
}
