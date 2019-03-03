<?php
require_once(ROOT . 'Models/Usuario.php');
require_once(ROOT . 'Models/Nivel_Usuario.php');
class indexController extends Controller{
    function index(){
		$this->model=new Usuario();
		$this->model->table_label='Dashboard';
		$this->render("index");
    }
	
	function login(){
		if(isset($_POST['login_user'])){
			$this->model=new Usuario();
			$row = $this->model->get_by_property(array('nombre_usuario'=>$_POST['email']));
			Session::set('logged_in',true);
			Session::getNdelete('log_out');
			Session::set('user_email',$_POST['email']);
			header('location: '.base_url().'index/index');
		}else{
			Session::set('log_out',true);
			Session::getNdelete('logged_in');
			Session::getNdelete('user_email');
			
			$this->render("login");	
		}
	}
}
?>