<?php 
	class CoreUtils{

		/**
		 * metodo para obtener contenido de archivo si existe
		 * @param string $file_url 
		 * @return string file content parse to string or ''
		 */
		public static function get_file_content($file_url){
			if(is_file($file_url))
				return file_get_contents($file_url);
			return '';
		}
		
		/**
		 * get file layout template content
		 * @param type $file_url 
		 * @param type $template_name 
		 * @return string
		 */
		public static function get_layout_template_content($file_url,$template_name){
			return self::get_file_content(LAYOUT_DIR . $template_name . 
				(($file_url!='')?('/'.$file_url):'') .'.php');
		}
		
		/**
		 * Description
		 * @param type $controller_class 
		 * @return type
		 */
		public static function get_controller_name($controller_class){
			return ucfirst(str_replace('Controller', '', get_class($controller_class)));
		}
		/**
		 * get content of a view file
		 * @param type $file_url 
		 * @param type $controller 
		 * @return string
		 */
		public static function get_view_file_content($file_url,$controller){
			return CoreUtils::get_file_content(VIEWS_DIR . 
					CoreUtils::get_controller_name($controller) . 
					'/' . $file_url . '.php');
		}
		
		/**
		 * Description
		 * @return type
		 */
		public static function validate_user_session(){
			if (!Session::check('logged_in') && !Session::check('log_out')) {
				Session::set('log_out',true);
				header("location: ".CoreUtils::base_url()."index/login");
			}
		}
		
		/**
		 * Description
		 * @param type $data 
		 * @return type
		 */
		public static function secure_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
		
		/**
		 * Description
		 * @param type $form 
		 * @return type
		 */
        public static function secure_form($form){
            foreach ($form as $key => $value){
                $form[$key] = $this->secure_input($value);
            }
        }
		
		/**
		 * Description
		 * @param type $content 
		 * @param type|null $title 
		 * @return type
		 */
        public static function put_in_card($content,$title=null){
			return '<div class="container">
						<div class="col-md-12 col-md-offset-2">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
								 <h6 class="m-0 font-weight-bold text-primary">'.
								 	$title.
								 '</h6>
								</div>
								<div class="card-body">
									<div id="dynamic_content">'.
										$content.'
									</div>
								</div>
							</div>
						</div>
					</div>';
        }

		/**
		 * Description
		 * @param type $menu_id 
		 * @return type
		 */
		public static function get_user_permissions_by_menu_id($menu_id){
			$role_id = Session::get('role_id');

			$row = (new Permiso())->get_by_property(
        		array('id_nivel_usuario'=>$role_id,'id_menu'=>$menu_id));

        	if(!isset($row) || !isset($row['id_permiso']))
				return null;
			
			$row['can_read'] = ($row['leer_permiso']=='Yes');
			$row['can_create'] = ($row['escribir_permiso']=='Yes');
			$row['can_update'] = ($row['editar_permiso']=='Yes');
			$row['can_delete'] = ($row['eliminar_permiso']=='Yes');

			return $row;
		}
		
		/**
		 * Description
		 * @param type $url 
		 * @return type
		 */
		public static function get_user_permissions($url){
        	$row_menu = (new Menu())->get_by_property(
        			array(
        				'url_menu'=>$url
        			)
        		);
        	if(!isset($row_menu))
        		return null;

        	return CoreUtils::get_user_permissions_by_menu_id($row_menu['id_menu']);
		}
		/**
		 * Description
		 * @param type $controller 
		 * @param type $action 
		 * @return type
		 */
        public static function get_user_permissions_by_controller($controller,$action){
        	return CoreUtils::get_user_permissions(
        			CoreUtils::get_controller_name($controller).'/'.$action);
        }

		/**
		 * Description
		 * @param type $controller 
		 * @param type $action 
		 * @param type $html_view 
		 * @return type
		 */
        public static function set_buttons_permissions($controller,$action,$html_view){
			$row = CoreUtils::get_user_permissions(
        			CoreUtils::get_controller_name($controller).'/'.$action);
			
			if(!isset($row))
				return $html_view;
        	
        	/* desabilitar botones de accion segun permisos de rol en menu(controlador/vista) acual */
			if(isset($row['can_create']) && $row['can_create']==false){
				$html_view .= '
				<script>
					$("#link_create").attr("href","#");
				</script><style>
					#link_create{display:none;}
				</style>';

			}
			if(isset($row['can_update']) && $row['can_update']==false){
				$html_view .= '<script>
					$("#link_edit").attr("href","#");
				</script>><style>
					#link_edit{display:none;}
				</style>';
			}
			if(isset($row['can_delete']) && $row['can_delete']==false){
				$html_view .= '<script>
					$("#link_delete").attr("href","#");
				</script>><style>
					#link_delete{display:none;}
				</style>';
			}
			
			return $html_view;
        }
		
		/**
		 * Description
		 * @return type
		 */
        public static function get_models(){
        	return array_diff(scandir(MODELS_DIR), array('.', '..'));
        }

		/**
		 * Description
		 * @return type
		 * /
        public static function get_models_to_sql(){
        	$models = array();
        	$tables = array();

        	$files = CoreUtils::get_models();
        	foreach($files as $file){
        		$file_name = MODELS_DIR . $file; 

        		$class_name = str_replace('.php', '', $file);
        		
        		if(is_file($file_name))
        			@require_once($file_name);

        		$model = new $class_name();

        		$models[] = $model;
        		$tables[] = $model->table_name;
        	}

        	$tables_sql="";
        	foreach($models as $model){
        		$tables_sql.= "Drop Table if Exists ".
        			$model->table_name.";";
        		$tables_sql.= "Create Table ".
        			$model->table_name."(";

        		foreach($model->table_fields as $table_field){
        			/* en proceso*** /
        		}
        		$tables_sql.= ")".
        			"ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        	}

        }
		*/

		public static function base_url(){
			$r = new Request();
			Router::parse($r->url, $r);
			$url='';
			
			if($r->real_controller!='' && $r->real_action!=''){
				$url.='../';
			}
			
			if($r->real_action!='' && count($r->real_params)>0){
				$url.='../';
			}
			return $url;
		}
		
	}
?>