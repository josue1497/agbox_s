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
                                           <button v-bind:m_id=\"id\" class=\"btn btn-primary\" v-on:click=\"sendAffiliationNotification(id,user);affiliated(id);\">Solicitar Afiliacion</button>
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
                        if(group_photo===\"\"){
                            document.getElementById(id).src='https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg'
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

        $this->model->table_label = 'Afiliacion a Grupos';
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
				$user_to=$gur->get_user_by_role('Lider',$_POST['group_id']);

				$entity_to=Model::get_sql_data("select id from affiliate order by id DESC limit 1 ");
        $affiliate_id=intval($entity_to[0]['id']);

       Notification::create_notification();
        
				$sql="INSERT INTO notification
        (message, user_to_id, entity_id, notification_type,controller_to, shipping_date, `read`)
        VALUES( 'Nueva Solicitud de Afilicacion', ".$user_to['id'].", '".++$affiliate_id."', 'affiliate','affiliate/approve_affiliate', 
        CURRENT_TIMESTAMP, 'N')";

        if($this->model->create($_POST)){
          echo Model::execute_update($sql);

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

      $role_group = array('user_id'=>$affiliate_record['user_id'],
                         'group_id'=>$affiliate_record['group_id'],
                          'role_id'=>$data['role_id']);

      $gur_model = new Group_User_Role();
      $req1=$gur_model->create($role_group);
      if($req1){
        $affiliate_record['approved']=$data['approved'];
        $req2=$affiliate_model->edit($data['record_id'], $affiliate_record);

          if($req2){
            $notification_model = new Notification();

          }
      }

      if($req1 && $req2){
        echo 'ok';
      }else{
        echo 'failed';
      }
      
    }
}

?>