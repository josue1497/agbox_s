<?php
/**
 * controlador para el crud de menu
 */
class group_user_roleController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Group_User_Role(),true);
    }
    
    /**
	 * metodo accion create que genera el form para agregar registros
	 * 
	 * @return void
	 */
    function create(){
		$this->action_create(new Group_User_Role(),$_POST,true);
    }
    
    /**
	 * metdo accion edit que genra el form para editar registros
	 * 
	 * @return void
	 */
    function edit($id){
		$this->action_edit($id,new Group_User_Role(),$_POST,true);
    }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Group_User_Role());
	}

	public function update_group_user_role(){
		$data = $_POST;

		$group_name=Group::get_group_name($data['group-id']);
		$role_name=Role::get_role_name($data['group_user_role']);

		if(Group_User_Role::set_user_role($data['group-id'],$data['user-id'],$data['group_user_role'])){
			if(Notification::create_notification(array('user_to_id'=>$data['user-id'], 
																									'message'=>'Su rol dentro del grupo '.$group_name.' ha cambiado',
																									'entity_id'=>$data['group-id'],
																									'notification_type'=>Notification::$CHANGE_ROLE,
																									'controller_to'=>'groups/group_information',
																									'read'=>Notification::$NO))){
				echo $data['affiliate-id'];
			}else{
				echo 'fail';
			}
		}else{
			echo 'fail';
		}

	
		

	}

	public function desaffiliate_group_user_role(){
		$data = $_POST;

		$group_name=Group::get_group_name($data['group-id']);

		if(Group_User_Role::delete_group_user_role($data['user-id'],$data['group-id'],$data['group_user_role'])
					&& Affiliate::delete_affiliation($data['affiliate-id'])){
			if(Notification::create_notification(array('user_to_id'=>$data['user-id'], 
																									'message'=>'Usted fue Desafiliado del grupo '.$group_name.'',
																									'entity_id'=>'',
																									'notification_type'=>Notification::$DESAFFILIATE_USER,
																									'controller_to'=>'#',
																									'read'=>Notification::$NO))){
						echo $data['affiliate-id'];
			}else{
				echo 'fail';
			}
		}else{
			echo 'fail';
		}

	

	}
}
?>