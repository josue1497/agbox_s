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
		$this->model=new Usuario();
		$this->model->table_label='Dashboard';
		$this->render("index");
    }

	/**
	 * metodo daccion inicio de sesion 
	 * 
	 * @return void
	 */
	function login(){
		$this->model=new Usuario();
		if(isset($_POST['login_user'])){
			$this->record = array();

			$row = $this->model->get_by_property(array('nombre_usuario'=>$_POST['email']));
			if(isset($row) && isset($row['id_usuario'])){
				if($row['clave_usuario'] == $_POST['password']){
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
		$this->render("login");	
	}
}
?>