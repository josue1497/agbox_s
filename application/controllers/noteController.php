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
}
