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
        $this->init(new User());

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
