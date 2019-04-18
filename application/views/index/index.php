<?php 
	
	$sql_groups = 
		"select gur.group_id,g.name,g.group_photo,g.description
		from groups g 
		inner join group_user_role gur on g.id=gur.group_id 
		where gur.user_id=?";
	
	function generate_content($controller,$filename=null,$record=null){
	$list = Model::get_sql_data($sql_groups,array('user_id'=>Session::get('user_id')));
	$list_html="";

	foreach($list as $map){
    $photo=$map['group_photo']?Component::img_to_base64(UPLOADS_DIR.$map['group_photo']):'https://i.ibb.co/pKgD4mH/image-group.png';
		$list_html.= '
		<div class="col-3">
            <div class="card bg-transparent border-0">
              <div class="d-flex flex-column">
              <div class="d-flex justify-content-center">
                <div class="d-flex align-items-center">
                  <i class="fas fa-2x text-gray-300"><img class="img-profile rounded-circle img-profile-user" src="'.$photo.'"></i>&nbsp;&nbsp;
                  <a href="#" data-toggle="modal" data-target="#group_info_modal" data-group-name="'.$map['name'].'"
                  data-group-id="'.$map['group_id'].'" data-group-desc="'.$map['description'].'"><i class="fas fa-ellipsis-v text-secondary"></i></a>
                </div>
              </div>
              <a class="text-decoration-none" href="'.CoreUtils::base_url().'groups/group_information/'.$map['group_id'].'">
                <div class="d-flex justify-content-center">
                  <div class="mt-1">
                    <div class="h6 mb-0 font-weight-bold text-gray-800"><p class="h6 text-center">'.$map['name'].'</p></div>
                  </div>
                </div>
                </a>
              </div>
            </div>
          </div>';
	}



    $html_result = file_get_contents(__DIR__ . '/index.html');

    $html_result = str_replace('{{ groups_horizontal_list }}', $list_html, $html_result);
	 
	return $html_result;
}

public function get_pending_notes(){
	$note_model = new Note();
	$user_id = Session::get('user_id');
	$group_list = Model::get_sql_data($sql_groups,array('user_id'=>$user_id));
	foreach($group_list as $group){
		$notes=$note_model->showAllRecords(array('user_id'));
	}
	
	
	
}

?>