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
}
 