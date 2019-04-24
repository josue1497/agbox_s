<?php
/**
 * controlador para el crud de menu
 */
class groupsController  extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Group(),true);
    }
	
	/**
	 * metodo accion items que genera miniaturas
	 * @return type
	 */
    function items(){
		$this->action_items(new Group(),true);
    }
    
    /**
    * metodo accion create que genera el form para agregar registros
    * 
    * @return void
    */
	function create(){
		$this->update_user_role_group();
		// $_POST['onsubmit']='return validateFields()';
		$this->action_create(new Group(),$_POST,true);
	}
	/**
	* metdo accion edit que genra el form para editar registros
	* 
	* @return void
	*/
	function edit($id){
		$this->update_user_role_group();
		$this->action_edit($id,new Group(),$_POST,true);
	 }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Group());
	}
	
	public function group_information($id){
		$this->init(new Group());
		$this->model->get_by_id($id);
		$d["record"] = $this->model->get_by_id($id);

		$this->set($d);
		$this->render('group_information');
	}

	public function update_user_role_group(){
		if(isset($_POST) && isset($_POST['name'])){
				$record = (new Group())->get_by_property(array('name'=>$_POST['name']));
				$status = Group_User_Role::set_group_lider($record['id'],$_POST['leader_id']);
			}
		}

		public function request_membership(){
			$affiliate_model = new Affiliate();
			$group_model = new Group();
			
			$data=$_POST;

			$group_record=$group_model->findByPoperty(array('id'=>$data['group_id']));

			if(isset($data)){
				foreach($data['users_id'] as $user_id){
					if($affiliate_model->create(array('user_id'=>$user_id,'group_id'=>$data['group_id']))){
						$affiliate_record=$affiliate_model->findByPoperty(array('user_id'=>$user_id,'group_id'=>$data['group_id']));
						if(Notification::create_notification(array('user_to_id'=>$user_id,
						'message'=>'A sido invitado a participar en el grupo "'.$group_record['name'].'"',
						'entity_id'=>$affiliate_record['id'],
						'notification_type'=>Notification::$REQUEST_MEMBERSHIP,
						'controller_to'=>'affiliate/approve_request',
						'read'=>Notification::$NO))){
							echo 'ok';
						}
					}else{
						echo 'fail';
					}
				}
				}
			}

			/**
    * metodo accion create que genera el form para agregar registros
    * 
    * @return void
    */
	function create_group(){
	
		$this->init(new Group());
		
		$pass=true;

		if(isset($_POST) && isset($_POST['name'])){
			$data=$_POST;
			if($this->model->create($data)){
				$group_record = (new Group)->findByPoperty(array('name'=>$data['name']));
				if(Affiliate::create_new_affiliate(array('user_id'=>$data['leader_id'],'group_id'=>$group_record['id']),true)){
						$this->update_user_role_group();
				}
				if(isset($data['user_affiliate'])){
						foreach($data['user_affiliate'] as $user){
							$pass=Affiliate::create_new_affiliate(array('user_id'=>$user,'group_id'=>$group_record['id']));
						}
				}
				if($pass){
					echo $group_record['id'];
				}				
			}
		}else{
			$this->render('create_group');
		}
	}

	public function get_group_members(){

		$data=$_POST;
		$id=$_POST['group_id'];
		
		$group_record = Model::get_sql_data("select CONCAT(u.names,' ',u.lastnames) user_name, r.name role_name
		from groups g inner join affiliate a on (a.group_id=g.id)
		inner join group_user_role gur on (gur.group_id=g.id and a.user_id=gur.user_id)
		inner join `user` u on (u.id=gur.user_id) 
		inner join `role` r on (r.id=gur.role_id)
		where g.id=?", array('group_id'=>$id));

		header('Content-Type: application/json');
  	echo json_encode($group_record,JSON_PRETTY_PRINT);
	}


}

 
						 
					
					
					
?>