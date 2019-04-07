<?php 
	function generate_content($controller,$filename=null,$record=null){

	$sql_groups = 
		"select gur.group_id,g.name,g.group_photo
		from groups g 
		inner join group_user_role gur on g.id=gur.group_id 
		where gur.user_id=?";

	$list = Model::get_sql_data($sql_groups,array('user_id'=>Session::get('user_id')));
	$list_html="";

	foreach($list as $map){
		$list_html.= '
		<div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
              <a href="'.CoreUtils::base_url().'groups/group_information/'.$map['group_id'].'">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    	<!--'.$map['name'].'-->
                    </div>
                    <div class="h6 mb-0 font-weight-bold text-gray-800">'.$map['name'].'</div>
                  </div>
                  <div class="col-auto">
                  	<i class="fas fa-2x text-gray-300">
                  		<img class="img-profile rounded-circle img-profile-user" src="'.Component::img_to_base64(UPLOADS_DIR.$map['group_photo']).'">
                  	</i>
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
?>