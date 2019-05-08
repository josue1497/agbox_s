<?php

// Controlador para configuraciones de Usuario
class configurationController extends Controller
{

    /**
     * metodo accion index que genera la grilla
     * 
     * @return void
     */
    function index()
    {
        $this->init(new User());

        $this->model->table_label = 'Configuracion';
        $this->render("user_configuration");
    }
}
