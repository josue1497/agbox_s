<?php 
	/**
	 *  clase de metodos utilitarios
	 */
	class CoreUtils{

		/**
		 * metodo para obtener contenido de archivo si existe.
		 *
		 * @param string $file_url 
		 * @return string file content parse to string or ''
		 */
		public static function get_file_content($file_url){
			if(is_file($file_url))
				return file_get_contents($file_url);
			return '';
		}
		
		/**
		 * metodo para obtener el contenido de una platilla
		 * 
		 * @param type $file_url 
		 * @param type $template_name 
		 * @return string
		 */
		public static function get_layout_template_content($file_url,$template_name){
			return self::get_file_content(LAYOUT_DIR . $template_name . 
				(($file_url!='')?('/'.$file_url):'') .'.php');
		}
		
		/**
		 * metodo para obtener el nombre de un controlador
		 * 
		 * @param type $controller_class 
		 * @return string nombre del controlador
		 */
		public static function get_controller_name($controller_class){
			return ucfirst(str_replace('Controller', '', get_class($controller_class)));
		}
		
		public static function get_view_file_url($file_url,$controller){
			return strtolower(VIEWS_DIR . self::get_controller_name($controller) . '/' . $file_url . '.php');
		}
		/**
		 * obtiene el contenido del archivo de una vista
		 *
		 * @param type $file_url nombre de la vista
		 * @param type $controller nombre de controlador
		 * @return string contenido de la vista
		 */
		public static function get_view_file_content($file_url,$controller){
			return strtolower(self::get_file_content(self::get_view_file_url($file_url,$controller)));
		}
		
		/**
		 * verifica si el usuario actual ha iniciado sesion,
		 * sino redirecciona a la vista de autenticacion
		 * 
		 * @return void
		 */
		public static function validate_user_session(){
			if (!Session::check('logged_in') && !Session::check('log_out')) {
				Session::set('log_out',true);
				header("location: ".CoreUtils::base_url()."index/login");
			}
		}
		
		/**
		 * metodo para sanitizar la informacion de un inpit element
		 * 
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
		 * sanitiza la informacion de los input de un formulario
		 * 
		 * @param type $form 
		 * @return type
		 */
        public static function secure_form($form){
            foreach ($form as $key => $value){
                $form[$key] = CoreUtils::secure_input($value);
            }
        }
		
		/**
		 * coloca un contenido html en un card
		 * 
		 * @param string $content contenido html
		 * @param string|null $title titulo del card
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
		 * coloca un contenido html en un card
		 * 
		 * @param string $content contenido html
		 * @param string|null $title titulo del card
		 * @return type
		 */
        public static function add_row_card(array $row){
			$html = '<div class="container">
						<div class="row">';
							foreach($row as $card){
							$html.=CoreUtils::add_new_card($card['content'],$card['title'],$card['dimension']);
						}
						$html.='
				</div></div>';
				//col-md-12 col-md-offset-2
				return $html;
			// return CoreUtils::put_in_card($html,'Title');
        }
		
		/**
		 * coloca un contenido html en un card
		 * 
		 * @param string $content contenido html
		 * @param string|null $title titulo del card
		 * @return type
		 */
        public static function add_new_card($content,$title=null,$dimesion="12"){

			return '<div class="col-md-'.$dimesion.' col-md-offset-2">
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">'.$title.'</h6>
							</div>
							<div class="card-body">
								<div id="dynamic_content">'.$content.'</div>
							</div>
						</div>
					</div>';
        }
		
		/* metodo para generar card */
		public static function generate_card($model,$content,$filename,$record = null){
			$card = CoreUtils::put_in_card($content,"{{ title_module }}");
			$card = str_replace(
					'{{ title_module }}',
					(isset($record['form_action'])?
						$record['form_action']:'').' '.
						$model->table_label.' &nbsp; '.
						/* agregar boton collapsable */
						(($filename == 'index' || $filename == 'items')? 
							Component::function_button('Toogle View',
								"if(!$('#index_".
									$model->table_name.
									"').parent().is(':visible')){".
									"$('#index_".
									$model->table_name.
									"').parent().fadeIn();}else{".
									"$('#index_".
									$model->table_name.
									"').parent().fadeOut();}")
							:'').' &nbsp; '.
						/* agregar boton cambio de vista (lista/cuadricula) */
						(($filename == 'index' || $filename == 'items')? 
							Component::function_button('Change View',(
									"if($('#index_".
									$model->table_name.
									"').is(':visible')){".
									"$('#index_".
									$model->table_name.
									"').fadeOut();".
									"$('#items_".
									$model->table_name.
									"').fadeIn();".
									"}else{".
									"$('#items_".
									$model->table_name.
									"').fadeOut();".
									"$('#index_".
									$model->table_name.
									"').fadeIn();}"
								)): '' ),
					$card);
				return $card;
		}

		/**
		 * obtiene los permisos del usuario logeado en el menu indicado
		 * 
		 * @param type $menu_id 
		 * @return array de permisos
		 */
		public static function get_user_permissions_by_menu_id($menu_id){
			$role_id = Session::get('role_id');

			$row = (new Permission())->get_by_property(
						array('user_level_id'=>$role_id,'menu_id'=>$menu_id));

        	if(!isset($row) || !isset($row['id']))
				return null;
			
			$row['can_read'] = ($row['can_read']=='Yes');
			$row['can_create'] = ($row['can_write']=='Yes');
			$row['can_update'] = ($row['can_edit']=='Yes');
			$row['can_delete'] = ($row['can_delete']=='Yes');

			return $row;
		}
		
		/**
		 * obtener permisos de un usuario segun una ruta de menu
		 *
		 * @param type $url rita de menu "controler/view"
		 * @return array de permisos
		 */
		public static function get_user_permissions($url){
        	$row_menu = (new Menu())->get_by_property(
        			array(
        				'url'=>$url
        			)
        		);
        	if(!isset($row_menu))
        		return null;

        	return CoreUtils::get_user_permissions_by_menu_id($row_menu['menu_id']);
		}
		/**
		 * obtiene los permisos de un usuario segun un controlador y una vista
		 *
		 * @param type $controller 
		 * @param type $action vista
		 * @return array de permisos
		 */
        public static function get_user_permissions_by_controller($controller,$action){
        	return CoreUtils::get_user_permissions(
        			CoreUtils::get_controller_name($controller).'/'.$action);
        }

		/**
		 * habilita o inhabilita los botones de accion segun los permisos del 
		 * usuario logeado
		 * 
		 * @param type $controller controlador
		 * @param type $action vista
		 * @param type $html_view contenido generado
		 * @return type contenido generado actualizado
		 */
        public static function set_buttons_permissions($controller,$action,$html_view){
			$row = CoreUtils::get_user_permissions(
        			CoreUtils::get_controller_name($controller).'/'.$action);
			
			if(!isset($row))
				return $html_view;
        	
        	/* deshabilitar botones de accion segun permisos de rol en menu(controlador/vista) acual */
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
		 * metodo para obtener todos los modelos
		 *
		 * @return array de modelos
		 */
        public static function get_models(){
        	return array_diff(scandir(MODELS_DIR), array('.', '..'));
        }

		/**
		 * metodo para generar todo el sql a partir de la informacion de los modelos
		 *
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
		
		/**
		 * metodo para generar el url base de la aplicacion independientemente 
		 * de la ruta en la que se encuentre el cursor en ese momento
		 *
		 * @return string url
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

		public static function get_notification_count(){

			$notification_record = Model::get_sql_data("SELECT count(id) notif FROM notification WHERE user_to_id=".Session::get('user_id')." AND `read`='N'");
			
			$notification_html='';

			foreach($notification_record as $notification){
				$count=intval($notification['notif'])>0;
				$notification_html.=$count? '<span class="badge badge-secondary badge-counter">'. $notification['notif'].'</span>':'';
			}

		  return $notification_html;
				}

		public static function get_user_notification(){

			$notification_record = Model::get_sql_data('SELECT * FROM notification WHERE user_to_id='.Session::get('user_id').' ORDER BY shipping_date DESC limit 10');
			
			$notification_html='';
			if(count($notification_record)>0){
				foreach($notification_record as $notification){
					$text=$notification['read']==="N"?"text-dark font-weight-bold ":"text-muted font-weight-normal";
					$uri_to=SERVER_DIR.$notification['controller_to'].'/'.$notification['entity_id'];
					$to_read = SERVER_DIR.'notification/read_notification';
				$notification_html.='<a class="dropdown-item d-flex align-items-center" onclick="toReadNotification(\''.$uri_to.'\',\''.$to_read.'\',\''.$notification['id'].'\');">
							'.self::get_notification_icon($notification['notification_type']).'
							<div>
								<div class="small text-gray-500">'.date("F j, Y, g:i a", strtotime($notification['shipping_date'])).'</div>
									<span class="'.$text.'">'.$notification['message'].'</span>
							</div>
						</a>';
				}
			
		}else{
			$notification_html.='<a class="dropdown-item d-flex align-items-center" href="#">
				<div class="mr-3">
				</div>
				<div>
				  <span class="font-weight-bold">there is not alerts!</span>
				</div>
			  </a>';
		}
		

		  return $notification_html;
				}

		public static function get_notification_icon($type){
			$html= '<div class="mr-3">
						<div class="icon-circle '.self::get_notification_color($type).'">';
			switch($type){
				case Notification::$AFFILIATE:
					$html.='<i class="fas fa-file-alt text-white"></i>';
				  break;

			}

			$html.='</div>
			</div>';
			
		  return $html;
		}		

		public static function get_notification_color($type){
			switch($type){
				case 'affiliate':
					return ' bg-success ';
			}
			
		}		
		
	}
?>