<?php

function generate_content($controller, $filename = null, $record = null)
{

  $sql_groups =
    "select gur.group_id,g.name,g.group_photo,g.description
		from groups g 
		inner join group_user_role gur on g.id=gur.group_id 
    where gur.user_id=?";

  $list = Model::get_sql_data($sql_groups, array('user_id' => Session::get('user_id')));
  $list_html = "";

  foreach ($list as $map) {
    $photo = $map['group_photo'] ? Component::img_to_base64(UPLOADS_DIR . $map['group_photo']) : 'https://i.ibb.co/pKgD4mH/image-group.png';
    $list_html .= '
		<div class="col-3">
            <div class="card bg-transparent border-0">
              <div class="d-flex flex-column">
              <div class="d-flex justify-content-center">
                <div class="d-flex align-items-center">
                  <i class="fas fa-2x text-gray-300"><img class="img-profile rounded-circle img-profile-user" src="' . $photo . '"></i>&nbsp;&nbsp;
                  <a href="#" data-toggle="modal" data-target="#group_info_modal" data-group-name="' . $map['name'] . '"
                  data-group-id="' . $map['group_id'] . '" data-group-desc="' . $map['description'] . '"><i class="fas fa-ellipsis-v text-secondary"></i></a>
                </div>
              </div>
              <a class="text-decoration-none" href="#' . $map['group_id'] . '">
                <div class="d-flex justify-content-center">
                  <div class="mt-1">
                    <div class="h6 mb-0 font-weight-bold text-gray-800"><p class="h6 text-center">' . $map['name'] . '</p></div>
                  </div>
                </div>
                </a>
              </div>
            </div>
          </div>';
  }


  $pendientes = get_pending_notes($list);

  $html_result = file_get_contents(__DIR__ . '/index.html');

  $html_result = str_replace('{{ groups_horizontal_list }}', $list_html, $html_result);

  $html_result = str_replace('{{ PENDINGS_NOTES }}', CoreUtils::add_new_card($pendientes, 'Pendientes'), $html_result);

  return $html_result;
}

function get_pending_notes($list_group)
{

  $function_result = '';
  $note_model = new Note();
  $user_id = Session::get('user_id');
  foreach ($list_group as $group) {

    $note_list = Model::get_sql_data(
      "select n.id ,n.title, n.finish_date, n.group_id , n.summary,
                                      g.name from note n 
                                      inner join note_type nt on (nt.id=n.note_type_id)
                                      inner join status s on (s.id=n.status_id)
                                      inner join `user` u on (n.performer_id=u.id)
                                      inner join groups g on (g.id=n.group_id)
                                      where n.performer_id=" . $user_id . " and g.id=" . $group['group_id'] . " and s.value='P' and nt.value='AS'
                                      order by n.finish_date"
    );
    if (!empty($note_list)) {
      $function_result .= build_groups($group, $note_list);
    }
  }

  return $function_result;
}

function build_groups($group, $list)
{
  $result = '<div class="row my-2">
  <div class="col-12">
    <div class="row">
      <div class="col-6 d-flex justify-content-center">
        <a href="' . SERVER_DIR . 'groups/group_information/' . $group['group_id'] . '" class="text-decoration-none">
          <h3 class="text-mutted ml-2" id="' . $group['group_id'] . '">' . $group['name'] . '</h3>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex flex-column">
        <ul class="list-group">
         ' . build_line($list) . '
        </ul>
      </div>
    </div>
  </div>
</div>';
  return $result;
}

function build_line($list_lines)
{
  $result = '';
  
  setlocale(LC_ALL,"es_ES");
  foreach ($list_lines as $line) {
    $result .= '<li class="list-group-item list-group-item-action border-0">
                <div class="d-flex ">
                    <div class="p-2" data-toggle="modal" data-target="#note-info-modal" data-note="'. $line['id'].'" 
                    data-title="'. $line['title'].'"  data-summary="'. $line['summary'].'" >' . $line['title'] . '</div>
                    <div class="p-2"><small><b>' . strftime ( "%d %b %g" , strtotime($line['finish_date'])) . '</b></small></div>
                    <div class="ml-auto p-2">
                        <div class="d-flex flex-row">
                            <div class="mx-2" >
                              <a  data-toggle="modal" data-target="#add-comment-modal" data-note="'. $line['id'].'" 
                                   data-title="'. $line['title'].'" data-author="'.Session::get('user_id').'" 
                                  '.Component::set_tooltip_info("Añadir comentario de Avance").'>
                                  <i class="fas fa-comment-alt-edit fa-lg text-secondary"></i>
                              </a>
                            </div>
                            <div class="mx-2">
                              <a data-toggle="modal" data-target="#reassing-note" data-whatever="@mdo" '.Component::set_tooltip_info("Reasignar.").'><i class="fas fa-share-square fa-lg text-secondary"></i></a>
                            </div>
                        </div>
                    </div>
              </div>
            </li>';
  }

  return $result;
}
