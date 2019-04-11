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
		$this->view->add_script_js('
		
		$(document).ready(function(){
		$(\'.slide-cont\').slick({
			dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
	],
			});
		});
	');

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