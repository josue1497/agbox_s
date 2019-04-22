<?php
	function generate_content($controller,$filename=null,$record=null){

		$record = $controller->vars;
		$this_record = $record['record'];
		
		$user_model = new User();

		$user_record = $user_model->findByPoperty(array('id' => $this_record['user_id']));
		$html_user=generate_user_div($user_record);
		

		$group_model = new Group();

		$group_record = $group_model->findByPoperty(array('id' => $this_record['group_id']));
		$html_group=generate_group_div($group_record);

		$html_result=file_get_contents(__DIR__.'/approve_affiliate.html');

		$html_result=str_replace('{{ USER_INFO }}',CoreUtils::add_new_card($html_user,'User Information'),$html_result);
        $html_result=str_replace('{{ APPROVE_BUTTTON }}',generate_button_approve($this_record),$html_result);
        $html_result=str_replace('{{ GROUP_USER }}',CoreUtils::add_new_card($html_group,'Group Information'),$html_result);
        // $html_result=str_replace('{{ ROLE_SECTION }}',CoreUtils::add_new_card( generate_role_user(),'Roles'),$html_result);

				$controller->view->add_script_js("function send_data(){
					$.post( '".SERVER_DIR."affiliate/approve_user',".
						"{record_id:".$this_record['id'].",approved:'Yes',role_id:$('#group_user_role').val()}".
						", function( data ) {
						console.log(data);
						if('ok'===data){
							location.href='".SERVER_DIR."';
						}
					});
				}
				
				function decline(){
					$.post( '".SERVER_DIR."affiliate/approve_user',".
						"{record_id:".$this_record['id'].",approved:'No',role_id:$('#group_user_role').val()}".
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

function generate_user_div($user){
	$emp_model = new Employee();
	$html='
	<div class="profile-img"><img class="card-img-top" src="'.Component::img_to_base64(UPLOADS_DIR.$user['profile_photo']).'" alt="Card image cap" style="width:50% !important;" ></div>
	<div class="card-body text-center">
	  <h5 class="card-title">'.$user['names'].' '.$user['lastnames'].'</h5>
	  <hr>
	  <p class="card-text text-justify"><b>Mail: </b>'.$user['mail'].' </p>
	  <p class="card-text text-justify"><b>Nick: </b>'.$user['username'].' </p>
	'.generate_role_user().'</div>';
	return $html;
} 

function generate_group_div($group){
	$html='
	<div class="profile-img"><img class="card-img-top" src="'
	.Component::img_to_base64(UPLOADS_DIR.$group['group_photo']).'" alt="Card image cap" style="width:50% !important;" ></div>
	<div class="card-body text-center">
	  <h5 class="card-title">'.$group['name'].'</h5>
	  <hr>
	  <p class="card-text text-center">'.$group['description'].' </p>
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

function generate_role_user(){
	$role = new Role();
	$all_roles=$role->showAllRecords();
	$html='<div class="form-group">
			<blockquote class="blockquote text-justify">
				<label for="group_user_role" class="">Role in the Group</label>
			</blockquote>
			<select name="group_user_role" id="group_user_role" class="select2 form-control">
				<option value="">Select a value</option>';
			foreach($all_roles as $rol){
				$html.='<option value="'.$rol['id'].'">'.$rol['name'].'</option>';
			}
	$html.='</select></div>';
	return $html;
} 

?>