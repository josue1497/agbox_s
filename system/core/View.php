<?php 
/**
 * clase base para gestionar la construccion de vistas
 */
class View{
	public $model;

	var $scripts = '';
		
	/**
	 * metodo auxiliar para dicionar scripts
	 * @param type $script_js 
	 * @return type
	 */
	public function add_script_js($script_js){
		$this->scripts .= $script_js;
		return $this;
	}

	/**
	 * metodo para obtener scrits agregados
	 * @return type
	 */
	public function get_script_js(){
		return $this->scripts;
	}


	/**
		 * constructor usa modelo para construir vista,
		 * a partir de configuraciones del modelo
 		 * 
 		 * @param model $model
 		 * @return void
		 */
	public function __construct($model){
		$this->model = $model;
	}

	/**
		 *  metodo para construir vista de formulario automaticamente,
		 * desde los datos del modelo
		 *
		 * @param type $form_content 
		 * @param type $data 
		 * @return type
		 */
	public function auto_build_form($form_content, $data){
		return "<form method='post' enctype='multipart/form-data' action='#' " . (isset($data['onsubmit']) ? " onsubmit='" . $data['onsubmit'] . "' " : "") .
			" >" .
			$form_content .
			"</form>";
	}

	public static function set_alert_bootstrap(){
		return '<div class=alert alert-warning alert-dismissible fade show" role="alert">
		<strong>Holy guacamole!</strong> You should check in on some of those fields below.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>';
	}
	/**
		 * metodo para construir contenido de la vista de formulario automaticamente,
	  	 * desde los datos del modelo
		 *
		 * @param type $data 
		 * @return type
		 */
	public function auto_build_form_content($data, $add_button=true){
		$form_content = '';
		$is_group=$this->model->table_name==='groups';
		$is_user=$this->model->table_name==='user';
		foreach ($this->model->table_fields as $form_field) {
			if ($form_field->get_visible_form() && $form_field->get_column_in_db()){
				if($is_group &&
						$form_field->get_type()===Column::$COLUMN_TYPE_PHOTO
				&& !isset($data[$form_field->get_table_field_name()])){
					$data[$form_field->get_table_field_name()]='image_group.png';
				}
				$form_content .= $this->build_element($form_field, $data);
					
			}
		}

		return $form_content .($add_button?
			Component::cancel_button($this->model->table_name) .
			Component::save_button():'');
	}

	/**
	 * metodo para generar una lista de items analoga a la lista grid
	 * @param type $item_list 
	 * @param type $data 
	 * @return type
	 */
	public function auto_build_items($item_list,$data){
		return
			 ($this->model->crud_config['can_create'] ? 
			 	Component::add_button($this->model->table_name) : '').
			'<div class="row col-md-12 centered">'.$item_list.'</div>';
	}

	/**
	 * metodo para construir la lista de items
	 * @param type $data 
	 * @return type
	 */
	public function auto_build_item_list($data){
		$item_list='';
		$i = 1;
		foreach ($data as $row) {
			 $item_list.=
			 //'<div class="col-md-4 p-3 m-2">'.
		       '<div class="col mr-2">'.
		       	'<div class="card rounded" style="width:18rem;">'
		         	;
		    
		     $url = 'https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg';
			$pic = '';

				foreach ($this->model->table_fields as $list_field){

		         	if( strpos(strtolower($list_field->get_name()), 'photo') !== false ){
		         		$pic = '<img class="card-img-top img-fluid image" ';
		         		
		         		
		         		if(isset($row[$list_field->get_name()]) && is_file($row[$list_field->get_name()])){
		         			$url = $row[$list_field->get_name()];
		         		}
						
								 if($list_field->get_type()==Column::$COLUMN_TYPE_PHOTO && 
								 $row[$list_field->get_name()]!=null){
									 $url=Component::img_to_base64(UPLOADS_DIR.$row[$list_field->get_name()]);
								 }

		         		$pic .= 'src="'.$url.'" '.
		            'alt="Card image cap" id="group-icon"/>';
		         	}
				}


		        $item_list.= $pic.
		          	'<div class="card-body">'.
			            '<h5 class="card-title text-center">';
			
			foreach ($this->model->table_fields as $list_field) {
				if($list_field->get_visible_grid() && $list_field->get_name_key() ){
					$item_list.= $row[$list_field->get_name()].' ';
				}
			}
			            
			 $item_list.=
			            '</h5><hr />'.
			            '<div class="d-flex justify-content-center">';
/*			              '<a href="#" class="btn btn-primary">Solicitar Afiliacion</a>'.*/
			 $item_list.=
			 	($this->model->crud_config['can_update'] ?
					Component::edit_button($this->model->table_name, $row[$this->model->id_field]) : '') . 
			 	($this->model->crud_config['can_delete'] ?
					Component::delete_button($this->model->table_name, $row[$this->model->id_field]) : '');
			 $item_list.=
			            '</div>'.
			          '</div>'.
			       '</div>'.
			     '</div>';
			    $i++;
		}
		return $item_list;
	}

	/**
	 * generar dinamicamente el contenido de lista como items
	 * @param type|null $data 
	 * @return type
	 */
	public function generate_item_list($data=null){
		return $this->auto_build_items($this->auto_build_item_list($data),$data);
	}
	
	/**
		 * metodo para construir vista de listado automaticamente,
		 * desde los datos del modelo
		 * 
		 * @param type $list_content 
		 * @param type $data 
		 * @return type
		 */
	public function auto_build_list($list_content, $data){
		/* activa paginacion */
		$this->add_script_js(
		"$(document).ready(function () {".
		"$('#table_".$this->model->table_name.
		"').DataTable({ 'pagingType':'full' });".
		"$('.dataTables_length').addClass('bs-select');".
		"});");
		/* paginacion */

		return ($this->model->crud_config['can_create'] ?
				Component::add_button($this->model->table_name) : '') .
		"<div class='row col-md-12 centered'>" .
			"<table id='table_".$this->model->table_name."' ".
			"class='table table-striped custab table-sm'>" .
			$list_content .
			"</table>" .
			"</div>";
	}

	/**
		 * metodo para construir contenido de la vista de listado automaticamente,
	 	 * desde los datos del modelo
		 * 
		 * @param type $data 
		 * @return type
		 */
	public function auto_build_list_content($data){
		return $this->auto_build_list_thead() .
			$this->auto_build_list_tbody($data);
	}

	/**
		 * metodo para construir cabecera del contenido de la vista de listado automaticamente,
		 * desde los datos del modelo
		 *
		 * @return type
		 */
	public function auto_build_list_thead(){
		$list_thead = "<thead>".
			"<tr>" .
			"<th>#</th>";

		foreach ($this->model->table_fields as $list_field)
			if ($list_field->get_visible_grid())
				$list_thead .= "<th class='th-sm' >" . ($list_field->get_label()) . "</th>";

		return $list_thead . "<th class='text-center'>Accion</th>" .
			"</tr>" .
			"</thead>";
	}

	/**
		 * metodo para construir cuerpo del contenido de la vista de listado automaticamente,
		 * desde los datos del modelo
		 * 
		 * @param type $data 
		 * @return type
		 */
	public function auto_build_list_tbody($data){
		$list_tbody = "<tbody>";
		$i = 1;
		foreach ($data as $row) {
			$list_tbody .= '<tr>' .
				"<td>" . $i++ . "</td>";
			foreach ($this->model->table_fields as $list_field) {
				if ($list_field->get_visible_grid()) {
					//if($list_field->get_type()==Column::$COLUMN_TYPE_SELECT)
					if ($list_field->get_foreing_key()) {
						$select_data = $list_field->get_fk_entity()->get_select_data($row[$list_field->get_name()]);
						$list_tbody .= "<td>" . $select_data[0]['name'] . "</td>";
					} else if ($list_field->get_type() == Column::$COLUMN_TYPE_PASS) {
						$list_tbody .= "<td>" . (str_repeat('*', strlen($row[$list_field->get_name()]))) . "</td>";
					} else if (Column::$COLUMN_TYPE_ICONPICKER) {
						$list_tbody .= "<td>" . $row[$list_field->get_name()] .
							" <i class='" . $row[$list_field->get_name()] . "'></i></td>";
					} else {
						$list_tbody .= "<td>" . $row[$list_field->get_name()] . "</td>";
					}
				}
			}
			$list_tbody .= "<td class='text-center'>" . ($this->model->crud_config['can_update'] ?
					Component::edit_button($this->model->table_name, $row[$this->model->id_field]) : '') . ($this->model->crud_config['can_delete'] ?
					Component::delete_button($this->model->table_name, $row[$this->model->id_field]) : '') .
				"</td>" .
				"</tr>";
		}
		return $list_tbody . "</tbody>";
	}

	/**
		 *  metodo para construir elementos de la vista,
		 * desde las especificaciones del modelo
		 *
		 * @param type $form_field 
		 * @param null|type $data 
		 * @return type
		 */
	public function build_element($form_field, $data=null)
	{
		$res = '';
		switch ($form_field->get_type()) {
			case Column::$COLUMN_TYPE_TEXTAREA:
				$res = Component::text_area(
					$form_field->get_name(),
					isset(	$data[$form_field->get_table_field_name()] ) ? $data[$form_field->get_table_field_name()]:'',
					$form_field->get_label(),
					$form_field->get_field_help(),
					$form_field->get_field_html()
				);
				break;
			case Column::$COLUMN_TYPE_SELECT:
				$res = Component::select_field(
					$form_field->get_name(),
					isset(	$data[$form_field->get_table_field_name()] ) ? $data[$form_field->get_table_field_name()]:'',
					$form_field->get_label(),
					($form_field->get_foreing_key() ? $form_field->get_fk_entity()->get_select_data() : $form_field->get_values()),
					$form_field->get_field_html()
				);
				break;

			case Column::$COLUMN_TYPE_ICONPICKER:
				$res = Component::icon_picker(
					$form_field->get_name(),
					isset(	$data[$form_field->get_table_field_name()] ) ? $data[$form_field->get_table_field_name()]:'',
					$form_field->get_label()
				);
				break;
			case Column::$COLUMN_TYPE_PHOTO:
				$res = Component::image_upload(
					$form_field->get_name(),
					isset(	$data[$form_field->get_table_field_name()] ) ? $data[$form_field->get_table_field_name()]:'',
					$form_field->get_label(),
					$form_field->get_file_type(),
					$form_field->get_field_html()
				);
				break;
				case Column::$COLUMN_TYPE_FILE:
				$res = Component::file_upload(
					$form_field->get_name(),
					isset(	$data[$form_field->get_table_field_name()] ) ? $data[$form_field->get_table_field_name()]:'',
					$form_field->get_label(),
					$form_field->get_file_type(),
					$form_field->get_field_html()
				);
				break;
			case Column::$COLUMN_TYPE_TEXT:
			case Column::$COLUMN_TYPE_DATE:
			case Column::$COLUMN_TYPE_EMAIL:
			case Column::$COLUMN_TYPE_HIDDEN:
			case Column::$COLUMN_TYPE_NUMBER:
			case Column::$COLUMN_TYPE_PASS:
			default:
				$res = Component::base_field(
					$form_field->get_type(),
					$form_field->get_name(),
					isset(	$data[$form_field->get_table_field_name()] ) ? $data[$form_field->get_table_field_name()]:'',
					$form_field->get_label(),
					$form_field->get_field_help(),
					$form_field->get_field_html()
				);
				break;
		}
		return $res;
	}

	public function buid_items_groups(){
		$html='';

		$data = Model::get_sql_data("select * from groups G where id not in (select group_id from affiliate where user_id=?)",array('user_id'=>Session::get('user_id')));
				foreach($data as $row){
							$click="affiliateGroup($('#form_".$row['id']."').serialize())";
							$img=$row['group_photo']!=null?Component::img_to_base64(UPLOADS_DIR.$row['group_photo']):'https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg';
							$html.='<div class="col m-2">
							<form method="POST" action="#" id="form_'.$row['id'].'">
							<input type="hidden" id="group_id" name="group_id" value="'.$row['id'].'"/>
							<input type="hidden" id="user_id" name="user_id" value="'.Session::get('user_id').'"/>
							<div class="card rounded" style="width: 18rem;">
									<img class="card-img-top img-fluid image"
											src="'.$img.'"
											alt="Card image cap" id="group-icon" />
									<div class="card-body">
											<h5 class="card-title text-center">'.$row['name'].'</h5>
											<hr />
											<div class="d-flex justify-content-center">
													<button class="btn btn-primary" onclick="'.$click.'">Solicitar Afiliacion</button>
											</div>
									</div>
							</div>
							</form>
						</div>';

						}
				return $html;
	}
}
 