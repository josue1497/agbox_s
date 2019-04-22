<?php
class userController extends Controller{
    function index(){
		$this->action_index(new User(),true);
    }
    function create(){
		$this->action_create(new User(),$_POST,true);
    }
    function edit($id){
		$this->action_edit($id,new User(),$_POST,true);
    }
    public function delete($id){
		$this->action_delete($id,new User());
	}
	public function profile(){
		$this->init(new User());
		$this->model->table_label='Perfil de Usuario';

		if(isset($_POST)){
			$data=$_POST;
			$data['id']=Session::get('user_id');
			$this->model->save_record($this->model,$data);
		}

		$this->render("perfil");
	}
	public function perfil(){
		$this->profile();
	}

	public function unaffiliate(){
		$user_id = $_POST['user_id'];
		$role_id = $_POST['role_id'];
		$group_id=$_POST['group_id'];
		$affiliate_id=$_POST['affiliate_id'];

		$affiliate_model = new Affiliate();
		$params = array('user_id'=>$user_id,'group_id'=>$group_id);
		$affiliate_row = $affiliate_model->get_by_property($params);
		
		$status = false;
		
		/* si existe affiliacion eliminarla */
		if($affiliate_row){
			$status = $affiliate_model->delete($affiliate_row['id']);
		}
		
		$gur_model = new Group_User_Role();
		$params['role_id']=$role_id;
		$gur_row = $gur_model->get_by_property($params);

		/* si existe grupo-user-rol eliminarla*/
		if($gur_row){
			$status = $gur_model->delete($gur_row['id']);
		}

		/* ocultar el registro de afiliacion (luego no aparecera)*/
		echo '<script>
				$("#aff_'.$affiliate_id.'").hide();;
			</script>';
	}
}
?>