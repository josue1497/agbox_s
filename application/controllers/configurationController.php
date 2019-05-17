<?php

// Controlador para configuraciones de Usuario
class configurationController extends Controller
{

    /**
     * metodo accion index que genera la grilla
     * 
     * @return void
     */
    public function index()
    {
        $this->init(new User_Settings());

        $d["record"] = $this->model->get_by_property(array('user_id'=>Session::get('user_id')));

       if(!empty($_POST)){
           $data=$_POST;
           if($d["record"]){
               $res= array_merge($d["record"],$data);
           }
            else{
                 $res=$data;
                 $res['user_id']=Session::get('user_id');
            }
               

            if($this->model->save_record($this->model,$res)){
                header("location: ".CoreUtils::base_url().'index/index');
            }
       }
       
		$this->set($d);
        $this->model->table_label = 'Configuracion';
        $this->render("user_configuration");
    }


    public function save_index_icons(){

        Model::execute_update('delete from item_index_page where user_id='.$_POST['user_id'].';');

        $menus= $_POST['info'];
        $pass=true;
        foreach($menus as $menu){
            $pass=Item_Index_Page::create_new_icon($menu,$_POST['user_id']);
        }

        if($pass){
            echo 'ok';
        }else{
            echo 'fail';
        }
    } 
}
