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
			$this-> init(new User());
			$this->model->table_label = 'Query Console';

			$js="
			$( document ).ready(function() {
				console.log( 'document loaded' );
				$('#btn_execute').on('click', function(sql){ 
					var sql =document.getElementById('query_area').value;
					var jqxhr = $.post( \"".SERVER_DIR.strtolower(CoreUtils::get_controller_name($this))."/execute_update\",
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
		$this-> init(new User());
		$this->model->table_label = 'Query Console';
		$js="
		$( document ).ready(function() {
			console.log( 'document loaded' );
			$('#btn_execute').on('click', function(sql){ 
				var sql = document.getElementById('query_area').value;
				var jqxhr = $.post( \"".SERVER_DIR.strtolower(CoreUtils::get_controller_name($this))."/execute_query\",
							{sql:sql}, function(data, status) {
					if(data=='0' || data ==0){
						document.getElementById('alert_result').className='p-4 rounded bg-danger';
						document.getElementById('alert_result').innerText='No records for sql';
					}else{
						document.getElementById('alert_result').className='p-4 border rounded bg-success';
						document.getElementById('alert_result').innerText='SQL SUCCESS!';
						$('#result_sql').html(data);
						/*document.getElementById('result_sql').innerHtml = data;*/
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
		
		function execute_update(){
			$query = explode(';',$_POST['sql']);
			$result='';
			foreach($query as $sql){
				if(!empty($sql)){
					$result = Model::execute_update($sql);
					if(!$result){
						echo "ERROR SYNTAX QUERY: --->".$sql;
						break;
					}
				}
			}
			echo $result;
		}

		function execute_query(){

			$sql = $_POST['sql'];

			if(!empty($sql))	{
				$result = Model::execute_query($sql);
				if($result){
					$keys = array_keys($result[0]);
					echo $this->build_table($keys,$result);
					return;
				}
			}
			echo '0';
			return;
		}

		function build_table($keys,$result){
			
			$html = '<table class="table table-striped custab table-sm dataTable no-footer"><thead>';
			
			foreach($keys as $key){
				$html.='<th>'.$key.'</th>';
			}

			$html.='</thead><tbody>';
			foreach($result as $row){
				$html.='<tr>';
				foreach($keys as $key){
					$html.= '<td>'.(isset($row[$key])?$row[$key]:'').'</td>'; 
				}

				$html.='</tr>';
			}
			$html.='</tbody></table>';

			return $html;
		}
    
    
}
?>