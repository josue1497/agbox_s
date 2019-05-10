<?php
/**
 * controlador para el crud de menu
 */
class noteController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
		$this->action_index(new Note(),true);
    }
    
    /**
	 * metodo accion create que genera el form para agregar registros
	 * 
	 * @return void
	 */
    function create(){
		$this->action_create(new Note(),$_POST,true);
    }
    
    /**
	 * metdo accion edit que genra el form para editar registros
	 * 
	 * @return void
	 */
    function edit($id){
		$this->action_edit($id,new Note(),$_POST,true);
    }

    /**
	 * metodo accion delete que elimina un registro
	 * @return type
	 */
    public function delete($id){
		$this->action_delete($id,new Note());
	}
	
	public function note_information($id){
		$this->init(new Note());
		$d["record"] = $this->model->get_by_id($id);

		$this->set($d);
		$this->render('note_information');
	}

	public function note_to_approve($id){
		$this->init(new Note());
		$d["record"] = $this->model->get_by_id($id);

		$this->set($d);
		$this->render('note_to_approve');

	}
	
	/**
	 * Description
	 * @return type
	 */
	public function create_assignment(){
		$this->init(new Note());
		if(isset($_POST) && isset($_POST['title'])){


			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type =Note_Type::get_assignment_type();

			$status_id =Status::get_pending_status();

			if($status_id)
				$data['status_id']=$status_id;
			else
				$data['status_id']=1;
			
			if($note_type)
				$data['note_type_id']=$note_type;
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);

			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			
			$note_approver_model = new Note_Approver();

			// foreach($users_id as $user_id){
			// 	$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
			// 	Model::save_record($note_approver_model,$approver_data);
			// }

			if($note){
				Notification::create_notification(array('user_to_id'=>$data['performer_id'],
                'message'=>'Tiene una nueva tarea Asignada',
				'entity_id'=>$note['id'],
                'notification_type'=>Notification::$NEW_ASSIGNMENT,
                'controller_to'=>'note/note_information',
                'read'=>Notification::$NO));
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			}
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}
		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
		}
		$this->render('create_assignment');
	}

	public function create_suggested_point(){
		$this->init(new Note());

		if(isset($_POST) && isset($_POST['title'])){

			$users_id = $_POST['user_approved_id'];

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = Note_Type::get_suggested_point_type();

			$status_id =Status::get_pending_status();
			
			if($note_type)
				$data['note_type_id']=$note_type;
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}

		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
		}
		$this->render('create_suggested_point');
	}

	public function create_agenda_point(){
		$this->init(new Note());

		if(isset($_POST) && isset($_POST['title'])){

			$users_id = $_POST['user_approved_id'];

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = Note_Type::get_agenda_point_type();
			
			$status_id =Status::get_pending_status();

			if($note_type)
				$data['note_type_id']=$note_type;
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}

		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
		}
		$this->render('create_agenda_point');
	}

	public function create_commitment(){
		$this->init(new Note());

		if(isset($_POST) && isset($_POST['title'])){

			
			$users_id = $_POST['user_approved_id'];
			

			$data = $_POST;
			$data['user_id']=Session::get('user_id');

			/*TODO cambiar por un GlobalModuleConstants.Value*/
			$note_type = Note_Type::get_commitment_type();
			
			if($note_type)
				$data['note_type_id']=$note_type;
			else
				$data['note_type_id']=1;

			Model::save_record($this->model,$data);
			$note = $this->model->get_by_property(array('title'=>$data['title'],'summary'=>$data['summary']));
			$note_approver_model = new Note_Approver();

			foreach($users_id as $user_id){
				$approver_data=array('note_id'=>$note['id'],'user_id'=>$user_id);
				Model::save_record($note_approver_model,$approver_data);
			}

			if($note)
				header("location: ".CoreUtils::base_url().'note/note_information/'.$note['id']);
			else 
				header("location: ".CoreUtils::base_url().'note/index');
		}

		if(Session::get('group_id')){
			$this->vars['records']['group_id']=Session::get('group_id');
			Session::delete('group_id');
		}
		$this->render('create_commitment');
	}

	public function complete_assigment(){
		$this->init(new Note());
		if(isset($_POST) && isset($_POST['note_id'])){
			$id=$_POST['note_id'];
			$message_complete=$_POST['message'];
			$note_record= (new Note)->findByPoperty(array('id'=>$id));
			$user_id = $note_record['performer_id'];
			$group_id = $note_record['group_id'];
			$note_record['status_id']=Status::get_complete_status();
			$leader_id=Affiliate::get_user_by_role('L',$group_id);

			if(Model::save_record($this->model,$note_record)){
					Note_Comment::create_comment($id,$user_id, $message_complete);
					Notification::create_notification(array('user_to_id'=>$leader_id['id'],
					'message'=>'Asignacion completada',	'entity_id'=>$id,
					'notification_type'=>Notification::$ASSINGMENT_COMPLETE,
					'controller_to'=>'note/process_assigment',
					'read'=>Notification::$NO));
					echo $id;
			}else{
				echo 'fail';
			}
		}
	}

	public function reasing_assigment(){
		$this->init(new Note());
		if(isset($_POST) && isset($_POST['note_id'])){
			$id=$_POST['note_id'];
			$message_complete=$_POST['message'];
			$note_record= (new Note)->findByPoperty(array('id'=>$id));
			$user_id = $note_record['performer_id'];
			$group_id = $note_record['group_id'];
			$note_record['status_id']=Status::get_paused_status();
			$leader_id=Affiliate::get_user_by_role('L',$group_id);
			$note_record['performer_id']=$leader_id;

			if(Model::save_record($this->model,$note_record)){
					Note_Comment::create_comment($id,$user_id, $message_complete);
					Notification::create_notification(array('user_to_id'=>$leader_id['id'],
																									'message'=>'Solicitud de reasignación',
																									'entity_id'=>$id,
																									'notification_type'=>Notification::$ASSINGMENT_REASING,
																									'controller_to'=>'note/process_assigment',
																									'read'=>Notification::$NO));
					echo $id;
			}else{
				echo 'fail';
			}
		}
	}

	public function assigment_complete(){
		$this->init(new Note());	
		if(isset($_POST) && isset($_POST['note-id'])){
			$this_note = $this->model->get_by_id($_POST['note-id']);
			$this_note['status_id']=Status::get_close_status();
			$last_user=Session::get('user_id');
			if(Model::save_record($this->model,$this_note)){
				Notification::create_notification(array('user_to_id'=>$this_note['performer_id'], 
																			'message'=>'Tu asignacion fue cerrada.', 
																			'entity_id'=>$this_note['id'], 
																			'notification_type'=>Notification::$CLOSE_ASSIGNMENT, 
																			'controller_to'=>'note/note_information', 
																			'read'=>Notification::$NO));
				Note_Comment::create_comment($this_note['id'],$last_user,$_POST['close-comment']);
			}
		}

	}

	public function assigment_reasing(){
		$this->init(new Note());
			if(isset($_POST) && isset($_POST['note-id'])){
				$this_note = $this->model->get_by_id($_POST['note-id']);
				$this_note['status_id']=Status::get_pending_status();
				$last_user=Session::get('user_id');
				$this_note['performer_id']=$_POST['user_to_affiliate_id'];

				if(Model::save_record($this->model,$this_note)){
					Notification::create_notification(array('user_to_id'=>$this_note['performer_id'], 
																				'message'=>'Tienes una nueva asignacion pendiente', 
																				'entity_id'=>$this_note['id'], 
																				'notification_type'=>Notification::$NEW_ASSIGNMENT, 
																				'controller_to'=>'note/note_information', 
																				'read'=>Notification::$NO));
					Note_Comment::create_comment($this_note['id'],$last_user,$_POST['comment']);
				}
			}

	}

	public function process_assigment($id){
		$this->init(new Note());
		$d["record"] = $this->model->get_by_id($id);

		// if(isset($_POST)){
		// 	header("location: ".CoreUtils::base_url().'index/index');
		// }

		$this->set($d);
		$this->render('process_assigment');
	}

	public function worksheet(){
		$this->init(new Note());

		// if(!empty($_POST)){
		// 	echo json_encode($_POST);
		// }

		$this->render('worksheet');
	}

}
