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
		/*
		$this->model=new User();
		$this->view = new View($this->model);
		*/
		$this->model->table_label='Dashboard';
		$this->render("index");
    }

	/**
	 * metodo daccion inicio de sesion 
	 * 
	 * @return void
	 */
	function login(){
		$this->init(new User());
		
		/*
		$this->model=new User();
		$this->view = new View($this->model);
		*/
		if(isset($_POST['login_user'])){
			/*$this->model=new User();*/
			$this->record = array();

			$row = $this->model->get_by_property(array('username'=>$_POST['email']));
			if(isset($row) && isset($row['id'])){
				if($row['password'] == $_POST['password']){
					$row['lan']=$_POST['language'];
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

		/*$this->model=new User();*/
		$this->render("login");	
	}
}
?>