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
			$js="
			$( document ).ready(function() {
				console.log( 'document loaded' );
				$('#btn_execute').on('click', function(sql){ 
					var sql =document.getElementById('query_area').value;
					var jqxhr = $.post( \"".SERVER_DIR.strtolower(CoreUtils::get_controller_name($this))."/execute_query\",
                                {sql:sql}, function(data, status) {
                        if(data===\"\"){
							document.getElementById('alert_result').className='p-2 bg-danger';
							document.getElementById('alert_result').innerText=data;
                        }
                                        })
                        .fail(function() {
							alert( \"Ha ocurrido un Error.\" );
							document.getElementById('alert_result').className='p-2 bg-danger';
                                        });
				});
			});
			";
			$this->view->add_script_js($js);
			$this->render("index");
			
		}
		
		function execute_query(){
			echo Model::execute_query($_POST['sql']);
		}
    
    
}
?>