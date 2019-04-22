<?php
/**
 * controlador de incio de sesion y dashboard
 */
class indexController extends Controller{
	/**
	 * metodo accion dashboard
	 * 
	 * @return void
	 */
    function index(){
		$this->init(new User());

		$this->model->table_label='Dashboard';

		$js= file_get_contents(JS_DIR . 'index.js');

		$js = str_replace('{{ URI_DATA }}',SERVER_DIR."groups/get_group_members",$js);
		$js = str_replace('{{ SEND_COMMENT }}',SERVER_DIR."note_comment/create",$js);
		$js = str_replace('{{ COMMMENT_DATA }}',SERVER_DIR."note_comment/get_comments",$js);
		$js = str_replace('{{ COMPLETE_ASSINGMENT }}',SERVER_DIR."note/complete_assigment",$js);

		

		$this->view->add_script_js($js);

	if(Affiliate::count_affilate_groups(Session::get('user_id'))==='0'){
		header("location: ".CoreUtils::base_url().'affiliate/items');
	}
	
	$this->render("index");
    }

	/**
	 * metodo daccion inicio de sesion 
	 * 
	 * @return void
	 */
	function login(){
		$this->init(new User());

		if(isset($_POST['login_user'])){
			$this->record = array();

			$row = $this->model->get_by_property(array('username'=>$_POST['email']));
			if(isset($row) && isset($row['id'])){
				if($row['password'] == $_POST['password']){
					$row['lan']=isset($_POST['language'])?$_POST['language']:'';
					Session::set_user_session_data($row);
					header('location: '.CoreUtils::base_url().'index/index');
				}else{
					$this->record['error_message']='error_msg_password';
				}
			}else{
				$this->record['error_message']='error_msg_email';
			}
		}else{
			Session::unset_user_session_data();
		}
		$this->render("login");	
	}
}
?>