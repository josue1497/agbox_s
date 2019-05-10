<?php
	function generate_content($controller,$filename=null,$record=null){

		$record = $controller->vars;
		$this_record = $record['record'];
		
		$user_model = new User();

		$user_record = $user_model->findByPoperty(array('id' => Session::get('user_id')));
		// $html_user=generate_user_div($user_record);
		

		$group_model = new Group();

		$group_record = $group_model->findByPoperty(array('id' => $this_record['group_id']));
		$html_group=generate_group_div($group_record);

		$html_result=file_get_contents(__DIR__.'/approve_request.html');

		// $html_result=str_replace('{{ USER_INFO }}',CoreUtils::aSdd_new_card($html_user,'User Information'),$html_result);
        $html_result=str_replace('{{ APPROVE_BUTTTON }}',generate_button_approve($this_record),$html_result);
        $html_result=str_replace('{{ GROUP_USER }}',CoreUtils::add_new_card($html_group,'Group Information'),$html_result);

				$controller->view->add_script_js("function send_data(){
					$.post( '".SERVER_DIR."affiliate/response_to_request',".
						"{record_id:".$this_record['id'].",approved:'Yes'}".
						", function( data ) {
						console.log(data);
						if('ok'===data){
							location.href='".SERVER_DIR."';
						}
					});
				}
				
				function decline(){
					$.post( '".SERVER_DIR."affiliate/response_to_request',".
						"{record_id:".$this_record['id'].",approved:'No'}".
						", function( data ) {
						console.log(data);
						if('ok'===data){
							location.href='".SERVER_DIR."';
						}
					});
				}
				
				");
		return $html_result;
}

function generate_group_div($group){
	$html='
	<div class="profile-img"><img class="card-img-top" src="'
	.($group['group_photo']?Component::img_to_base64(UPLOADS_DIR.$group['group_photo']):Component::img_to_base64(IMG_DIR.'image-group.png')).'" alt="Card image cap" style="width:50% !important;" ></div>
	<div class="card-body text-center">
	  <h1 class="card-title">'.$group['name'].'</h1>
	  <hr>
	  <h3 class="card-text text-center">'.$group['description'].' </h3>
	</div>
  ';
	return $html;
} 

function generate_button_approve($affiliate){
	$disable =empty($affiliate['approved'])?'':'disabled ';
		return '<span class="result"></span><button class="btn btn-primary mx-3" '.$disable.
		' onclick="send_data()" >Accept</button>
	<button class="btn btn-secondary" '.$disable.' onclick="decline()">Decline</button>';
} 

?>