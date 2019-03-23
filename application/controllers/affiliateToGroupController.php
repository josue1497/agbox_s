<?php
/**
 * Clase que maneja la afiliacion de usuarios a algun grupo.
 */
class affiliateToGroupController extends Controller
{
    /**
	 * metodo accion dashboard
	 * 
	 * @return void
	 */
    function index()
    {
        $this->model = new Affiliate();

        $props = array('user_id' =>  Session::get('user_id'));
        
        $this->view = new View($this->model);

        $this->model->table_label = 'Afiliacion a Grupos';
        $this->render("affiliate_group");

    }

    function get_data(){
        $data = Model::get_sql_data("select G.*, ? as user from groups G where id not in (select group_id from affiliate where user_id=?)",
                            array('user_id'=>Session::get('user_id'),'user_id2'=>Session::get('user_id')));
        header('Content-Type: application/json');
        echo json_encode($data,JSON_PRETTY_PRINT);
    }

    function insert_data(){  
        $this->model = new Affiliate();
       echo $this->model->create($_POST); 
    }

    function get_img(){
      $photo= Component::img_to_base64(UPLOADS_DIR.$_POST['group_photo']);
      echo $photo;
    }
}
 