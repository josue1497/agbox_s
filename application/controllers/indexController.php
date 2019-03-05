<?php
class indexController extends Controller{
    function index(){
		$this->model=new User();
		$this->model->table_label='Dashboard';
		$this->render("index");
    }
	
	function login(){
		if(isset($_POST['login_user'])){
			$this->model=new User();
			$this->record = array();

			$row = $this->model->get_by_property(array('username'=>$_POST['email']));
			if(isset($row) && isset($row['id'])){
				if($row['password'] == $_POST['password']){
					Session::set_user_session_data($row);
					header('location: '.CoreUtils::base_url().'index/index');
				}else{
					$this->record['error_message']='La contrase&ntilde;a ingresada es incorrecta.';
				}
			}else{
				$this->record['error_message']='El email ingresado no esta registrado.';
			}
		}else{
			Session::unset_user_session_data();
		}

		$this->model=new User();
		$this->render("login");	
	}
}
?>