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
		$this->view->add_script_js(' $(\'.slide-cont\').slick({
			centerMode: true,
			centerPadding: \'60px\',
			slidesToShow: 3,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						arrows: false,
						centerMode: true,
						centerPadding: \'40px\',
						slidesToShow: 3
					}
				},
				{
					breakpoint: 480,
					settings: {
						arrows: false,
						centerMode: true,
						centerPadding: \'40px\',
						slidesToShow: 1
					}
				}
			]
	});');
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