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
		
        $js=" Vue.component('affiliate-component',{
            props : ['group_photo',
                    'name',
                    'user',
                    'id'],
            template : `<div class=\"col-md-3 p-3 m-2\">
                            <div class=\"card rounded \" style=\"width: 18rem;\">
                            <div class=\"d-flex justify-content-center\">
                                <img class=\"card-img-top img-fluid image img-group\"  alt=\"Card image cap\"  v-bind:id=\"id\"/>
                            </div>
                            <div class=\"card-body\">
                                   <h5 class=\"card-title text-center\">{{name}}</h5>
                                   <hr />
                                   <div class=\"d-flex justify-content-center\">
                                           <button v-bind:m_id=\"id\" class=\"btn btn-primary\" v-on:click=\"sendAffiliationNotification(id,user);affiliated(id);\">Solicitar Afiliación</button>
                                   </div>
                                </div>
                            </div>`,
            methods:{
                sendAffiliationNotification: function(group_id, user_id){
                var jqxhr = $.post( \"{{ URI_INSERT }}\",
                                {user_id:user_id, group_id:group_id}, function(data, status) {

                                    console.log(data);
                                        })
                        .fail(function() {
                            alert( \"Ha ocurrido un Error.\" );
                                        });
                    },
                getGroupPhoto: function(group_photo,id){
                    var jqxhr = $.post( \"".SERVER_DIR."affiliate/get_img\",
                                {group_photo:group_photo}, function(data, status) {
                        if(group_photo===\"\" || group_photo==null){
                            document.getElementById(id).src='https://i.ibb.co/pKgD4mH/image-group.png'
                            
                        }else{
                       document.getElementById(id).src=data;
                        }
                                        })
                        .fail(function() {
                            alert( \"Ha ocurrido un Error.\" );
                                        });
                                      
                    },
                    affiliated: function (e){
											console.log(e);
											$('[m_id='+e+']').attr('id','m_'+e);
											$('#m_'+e).attr('class', 'btn btn-success');
                      $('#m_'+e).text('Solicitado');
                      $('#m_'+e).attr('disabled','disabled');
                    }},
created:function () { 
   this.getGroupPhoto(this.group_photo, this.id);
    },

       });
var urlPosts = '{{ URI_DATA }}';
var app = new Vue({
  el: '#app',
  created: function() {
    this.getData()
},
  data : { groups: [],fill:false,load:false },
  methods: {
    getData: function() {
        axios.get(urlPosts).then(response => {
        this.fill=!response.data.length>0;
        this.groups = response.data;
        this.load=false;
    });
    }
      }
});";
        $js = str_replace('{{ URI_DATA }}',SERVER_DIR."affiliate".'/get_data',$js);
        $js = str_replace('{{ URI_INSERT }}',SERVER_DIR."affiliate".'/insert_data',$js);


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

				$gur = new Group_User_Role();
				$user_to=$gur->get_user_by_role('L',$_POST['group_id']);

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

      
      $req1=Group_User_Role::set_user_role($affiliate_record['group_id']
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


      $leader_record= Group_User_Role::get_user_by_role('L',$affiliate_record['group_id']);
      $leader_id= $leader_record['id'];

      $user_model=new User();
      $user_rec=$user_model->findByPoperty(array('id'=>$affiliate_record['user_id']));
      
      $group_model=new Group();
      $group_rec=$group_model->findByPoperty(array('id'=>$affiliate_record['group_id']));

      if($data['approved']==='Yes'){
        if($affiliate_model->edit($affiliate_record['id'],$affiliate_record)){
        
          if(Group_User_Role::set_user_role($affiliate_record['group_id'],
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

}


?>