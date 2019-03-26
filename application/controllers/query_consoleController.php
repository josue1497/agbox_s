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
                        if(data!==\"1\"){
							document.getElementById('alert_result').className='p-4 rounded bg-danger';
							document.getElementById('alert_result').innerText=data;
                        }else{
							document.getElementById('alert_result').className='p-4 border rounded bg-success';
							document.getElementById('alert_result').innerText='SQL SUCCESS!';
						}
                                        })
                        .fail(function() {
							alert( \"Ha ocurrido un Error.\" );
							document.getElementById('alert_result').className='p-4 bg-gradient-success';
                                        });
				});
			});
			";
			$this->view->add_script_js($js);
			$this->render("index");
			
		}

		/**
	 * metodo accion index que genera la grilla
	 * 
	 * @return void
	 */
    function select_query(){
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
					if(data!==\"1\"){
						document.getElementById('alert_result').className='p-4 rounded bg-danger';
						document.getElementById('alert_result').innerText=data;
					}else{
						document.getElementById('alert_result').className='p-4 border rounded bg-success';
						document.getElementById('alert_result').innerText='SQL SUCCESS!';
					}
									})
					.fail(function() {
						alert( \"Ha ocurrido un Error.\" );
						document.getElementById('alert_result').className='p-4 bg-gradient-success';
									});
			});
		});
		";
		$this->view->add_script_js($js);
		$this->render("select_query");
		
	}
		
		function execute_query(){
			$query = explode(';',$_POST['sql']);
			$result='';
			foreach($query as $sql){
				if(!empty($sql)){
				$result = Model::execute_query($sql);
				if(!$result){
					echo "ERROR SYNTAX QUERY: --->".$sql;
					break;
				}
			}
			}
			echo $result;
		}
    
    
}
?>