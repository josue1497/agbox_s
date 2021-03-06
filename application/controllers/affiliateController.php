<?php
/**
 * controlador para el crud de menu
 */
class affiliateController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Affiliate(),true);
    }
    
    /**
	 * metodo accion create que genera el form para agregar registros
	 * 
	 * @return void
	 */
    function create(){
		$this->action_create(new Affiliate(),$_POST,true);
    }
    
    /**
	 * metdo accion edit que genra el form para editar registros
	 * 
	 * @return void
	 */
    function edit($id){
		$this->action_edit($id,new Affiliate(),$_POST,true);
    }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Affiliate());
	}
	public function approve_affiliate($id){
		$this->model=new Affiliate();
		$this->model->get_by_id($id);
		$this->view = new View($this->model);
		$this->view_processor = new ViewProcessor($this->view);

		$this->init($this->model);
		$d["record"] = $this->model->get_by_id($id);

		$this->set($d);

		$this->render('approve_affiliate');
	}

	function items(){
		$this->init(new Affiliate());
		
        $js=file_get_contents(JS_DIR . 'affiliate.js');
        $js = str_replace('{{ URI_DATA }}',SERVER_DIR."affiliate".'/get_data',$js);
        $js = str_replace('{{ URI_INSERT }}',SERVER_DIR."affiliate".'/insert_data',$js);
        $js = str_replace('{{ PHOTO_GETTING }}',SERVER_DIR."affiliate/get_img",$js);
        $js = str_replace('{{ URI_MEMBERS }}',SERVER_DIR."groups/get_group_members",$js);
        $js = str_replace('{{ IMGS_GRUP }}',Component::img_to_base64(IMG_DIR.'image-group.png'),$js);

        
        $this->view->add_script_js($js);

        $this->model->table_label = 'Afiliación a Grupos';
        $this->render("items");

    }

    function get_data(){
        $data = Model::get_sql_data("select G.*, ? as user from groups G where id not in (select group_id from affiliate where user_id=?)",
                            array('user_id'=>Session::get('user_id'),'user_id2'=>Session::get('user_id')));
        header('Content-Type: application/json');
        echo json_encode($data,JSON_PRETTY_PRINT);
    }

    function insert_data(){  
				$this->model = new Affiliate();

				$user_to=$this->model->get_user_by_role('L',$_POST['group_id']);

				$entity_to=Model::get_sql_data("select max(id)+1 as 'id' from affiliate");
        $affiliate_id=intval($entity_to[0]['id']);
        echo $entity_to[0]['id'];
        if($this->model->create($_POST)){
          echo  Notification::create_notification(array('user_to_id'=>$user_to['id'],
                'message'=>'Nueva Solicitud de Afilicacion',
                'entity_id'=>$affiliate_id,
                'notification_type'=>Notification::$AFFILIATE,
                'controller_to'=>'affiliate/approve_affiliate',
                'read'=>Notification::$NO));

        }        
    }

    function get_img(){
      $photo= Component::img_to_base64(UPLOADS_DIR.$_POST['group_photo']);
      echo $photo;
    }

    function approve_user(){
     
      $data =$_POST;
      $affiliate_model = new Affiliate();
      $affiliate_record = $affiliate_model->get_by_property(array('id'=>$data['record_id']));

      if('No'===$data['approved']){
        $req1=$affiliate_model->delete($data['record_id']);
       if($req1){
        Notification::create_notification(array('user_to_id'=>$affiliate_record['user_id'],
        'message'=>'Solicitud Declinada',
        'entity_id'=>$affiliate_record['group_id'],
        'notification_type'=>Notification::$DECLINE_AFFILIATE,
        'controller_to'=>'#',
        'read'=>Notification::$NO));

        echo 'ok';
       }
      }else{
      $role_group = array('user_id'=>$affiliate_record['user_id'],
                         'group_id'=>$affiliate_record['group_id'],
                          'role_id'=>$data['role_id']);

      
      $req1=Affiliate::set_user_role($affiliate_record['group_id']
                ,$affiliate_record['user_id'],$data['role_id']);
      if($req1){
        $affiliate_record['approved']=$data['approved'];
        $req2=$affiliate_model->edit($data['record_id'], $affiliate_record);

          if($req2){
            Notification::create_notification(array('user_to_id'=>$affiliate_record['user_id'],
                'message'=>'Solicitud Aprobada',
                'entity_id'=>$affiliate_record['group_id'],
                'notification_type'=>Notification::$APPROVE_AFFILIATE,
                'controller_to'=>'groups/group_information',
                'read'=>Notification::$NO));
          }
      }

      if($req1 && $req2){
        echo 'ok';
      }else{
        echo 'failed';
      }
     
      }
    }

    public function approve_request($id){
      $this->model=new Affiliate();
		  $this->model->get_by_id($id);
		  $this->view = new View($this->model);
		  $this->view_processor = new ViewProcessor($this->view);

		  $this->init($this->model);
		  $d["record"] = $this->model->get_by_id($id);

		  $this->set($d);

		  $this->render('approve_request');
    }


    public function response_to_request(){
      $data=$_POST;

      $role_id = Role::get_role_id_by_name('Miembro');
      $affiliate_model= new Affiliate();
      $affiliate_record=$affiliate_model->findByPoperty(array('id'=>$data['record_id']));
      $affiliate_record['approved']=$data['approved'];


      $leader_record= Affiliate::get_user_by_role('L',$affiliate_record['group_id']);
      $leader_id= $leader_record['id'];

      $user_model=new User();
      $user_rec=$user_model->findByPoperty(array('id'=>$affiliate_record['user_id']));
      
      $group_model=new Group();
      $group_rec=$group_model->findByPoperty(array('id'=>$affiliate_record['group_id']));

      if($data['approved']==='Yes'){
        if($affiliate_model->edit($affiliate_record['id'],$affiliate_record)){
        
          if(Affiliate::set_user_role($affiliate_record['group_id'],
                                            $affiliate_record['user_id'],
                                            $role_id)){
              Notification::create_notification(array('user_to_id'=>$leader_id,
                                      'message'=>$user_rec['names'].' es el Nuevo Miembro 
                                        del Grupo "'.$group_rec['name'].'"', 
                                      'entity_id'=>$affiliate_record['group_id'], 
                                      'notification_type'=>Notification::$NEW_MEMBER,
                                      'controller_to'=>'groups/group_information', 
                                      'read'=>Notification::$NO));
                        echo 'ok';
                                          }
        }else{
          echo 'fail';
        }
      }else{
            if($affiliate_model->delete($affiliate_record['id'])){
              Notification::create_notification(array('user_to_id'=>$leader_id,
              'message'=>$user_rec['names'].' rechazo la solicitud de entrar al grupo "'.$group_rec['name'].'"', 
              'entity_id'=>$affiliate_record['group_id'], 
              'notification_type'=>Notification::$NEW_MEMBER,
              'controller_to'=>'groups/group_information', 
              'read'=>Notification::$NO));
              
              echo 'ok';
            }else{
              echo 'fail';
            }
      }

    }

    public function get_user_affiliate(){

      $user_record = Model::get_sql_data("select u.id, CONCAT(u.names,' ',u.lastnames) text from `user` u where id in (select a.user_id from 
                                    affiliate a inner join groups g on (a.group_id=g.id) 
                                    where a.group_id=? and a.approved='Yes')", array('group_id'=>$_POST['group_id']));

      echo json_encode($user_record);
    }

    /* metodos agregads de group_user_roleController */

    public function update_group_user_role(){
		$data = $_POST;

		$group_name=Group::get_group_name($data['group-id']);
		$role_name=Role::get_role_name($data['group_user_role']);

		if(Affiliate::set_user_role($data['group-id'],$data['user-id'],$data['group_user_role'])){
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
		if(Affiliate::delete_group_user_role($data['user-id'],$data['group-id'],$data['group_user_role'])
					&& Affiliate::delete_affiliation($data['affiliate-id'])){
			if(Notification::create_notification(array('user_to_id'=>$data['user-id'], 
			'message'=>'Usted fue Desafiliado del grupo '.$group_name.'',
			'entity_id'=>'','notification_type'=>Notification::$DESAFFILIATE_USER,
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