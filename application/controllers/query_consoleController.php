<?php
/**
 * controlador para el crud de menu
 */
class query_consoleController extends Controller{
	/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function index(){
			$this->model = new User();
      $this->view = new View($this->model);
			$this->view_processor = new ViewProcessor($this->view);

			$this->model->table_label = 'Query Console';
			$this->render("index");
			
		}
		
		function execute_query(){
			echo Model::execute_query($_POST['sql']);
		}
    
    
}
?>