<?php
/**
 * clase base de controlador que gestiona las acciones, 
 * carga y usa los modelos, y genera las vistas
 */
    class Controller{
        var $vars = array();
        var $layout = TEMPLATE_NAME;
		var $model;
		var $view;
		var $view_processor;
		
        function set($d){
            $this->vars = array_merge($this->vars, $d);
        }
		
		function auto_build_view($filename,$records = null,$record = null){
			/* si el archivo/accion a cargar es index(lista)*/
				if($filename == '' || $filename == 'index'){
					return 
						'<div id="index_'.$this->model->table_name.
							'" style="display:block;">'.
							$this->view->auto_build_list(
								$this->view->auto_build_list_content($records),$records).
							'</div><div id="items_'.$this->model->table_name.
								'" style="display:none;">'.
							$this->view->generate_item_list($records).
						'</div>';
				}else 
				/* si el archivo/accion a cargar es form(form create/edit)*/
				if($filename=='form'){
					return $this->view->auto_build_form($this->view->auto_build_form_content($record),$record);
				}else 
				/* si el archivo/accion a cargar es items(cuadricula) */
				if($filename=='items'){
					return
						'<div id="index_'.$this->model->table_name.
								'" style="display:none;">'.
								$this->view->auto_build_list(
									$this->view->auto_build_list_content($records),$records).
								'</div><div id="items_'.$this->model->table_name.
									'" style="display:block;">'.
						 		$this->view->generate_item_list($records).
						 	'</div>';
				}else if('info'){
					return $this->view->auto_build_info_content($record);
				}
			/* si el archivo/accion es distinto a los definidos */
			return '';
		}
		
		function render($filename,$auto_build=false){
			extract($this->vars);
			
			/* sanitize data */
			$html_content = '';
			
			$record = array();
			if(isset($this->vars['record']))
				$record = $this->vars['record'];
			
			$records = array();
			if(isset($this->vars['records']))
				$records = $this->vars['records'];
			
			
			if(Session::get('log_out')){
				/* si no esta logueado o si cierra sesion se carga el contenido de login sin topbar ni sidebar */
				include_once(VIEWS_DIR. strtolower(CoreUtils::get_controller_name($this)).'/login.php');
				$this->view_processor->add_content(generate_content($this,'login',$record));
/*
				$this->view_processor->add_content(CoreUtils::get_view_file_content('login',$this));
				*/
			}else{
				$tmp = CoreUtils::get_user_permissions_by_controller($this,$filename);
				if(isset($tmp) && isset($tmp['id'])){
					$this->model->crud_config = $tmp;
				}

				/*si esta logueado se carga el sidebar y el topbar */
				$this->view_processor->set_topbar(CoreUtils::get_layout_template_content('topbar',$this->layout));
				$this->view_processor->set_sidebar(CoreUtils::get_layout_template_content('side',$this->layout));
				
				/* si se establece que la vista se construira automaticamente */
				if($auto_build){
					$this->view_processor->add_content(
						CoreUtils::generate_card(
							$this->model,
							$this->auto_build_view($filename,$records,$record),
							$filename,
							$record));
				}
				/* sino, la vista se construye a partir de un archiv de vista existente */
				else{
					/* intenta cargar el archivo de vista predefinido */
					$html_content = CoreUtils::get_view_file_content($filename,$this);
					if( !is_file(CoreUtils::get_view_file_url($filename,$this)) || $html_content == ''){
						/* si no lo consigue, carga el contenido del index por defecto*/
						
				include_once(VIEWS_DIR. strtolower(CoreUtils::get_controller_name(new indexController())).'/index.php');
				$this->view_processor->add_content(generate_content(new indexController(),'index',$record));
					}
					/* si la consigie arma la vista */
					else{
						if(isset($this->view)){
								include_once(VIEWS_DIR. strtolower(CoreUtils::get_controller_name($this)).'/'.$filename.'.php');
								$this->view_processor->add_content(generate_content($this,$filename,$record));
						}
						
					}
				}
			}
			
			/* set or hide admin_menu TODO */
			$user_level=new User_Level();
			$level_row = $user_level->get_by_id(Session::get('user_level_id'));
			if(!isset($level_row['access_level']) || 
				$level_row['access_level'] != 3){
				if($this->view){
					// $this->view->add_script_js('$(".admin_menu").each($(this).html(""));');
				}
			}

			/* styles, scripts, layout y footer son genericos para todas las vistas */
			$this->view_processor->set_layout(CoreUtils::get_layout_template_content('',$this->layout));
			$this->view_processor->set_styles(CoreUtils::get_layout_template_content('styles',$this->layout));
			$this->view_processor->set_scripts(CoreUtils::get_layout_template_content('scripts',$this->layout).
					( isset($this->view) ? ('<script>'.$this->view->get_script_js().'</script>'):''));
			$this->view_processor->set_footer(
			    str_replace(
					'{{ FOOTER_INFO }}',
					date("Y"),
					CoreUtils::get_layout_template_content('footer',$this->layout)));
			
			/* render */
			echo $this->set_general_data($this->view_processor->build_view(),$filename);
        }
		
		/**
		 * establece informacion general y standar en el html
		 * @param type $html_view 
		 * @param type $filename 
		 * @return type
		 */
		public function set_general_data($html_view,$filename){
			$html_view = str_replace(
					'{{ name_module }}',
					$this->model->table_name.'_module',
					$html_view);

			$html_view = str_replace(
					'{{ app_title }}',
					APP_NAME,
					$html_view);
							
			$html_view = str_replace(
				'{{ app_menu }}',
				$this->get_app_menu(),
				//'',
				$html_view);

				$admin_menu='<li class="nav-item  active admin_menu" >
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAjustes" aria-expanded="true" aria-controls="collapseAjustes">
				  <i class="fas fa-fw fa-chart-area"></i>
				  <span>Ajustes</span>
				</a>
				<div id="collapseAjustes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				  <div class="bg-white py-2 collapse-inner rounded">
					<!--<a class="collapse-item" href="#">Preferencias</a>
					<a class="collapse-item" href="#">Ajustes</a>-->
					<a class="collapse-item" href="{{ base_url }}menu/index">Menu</a>
					<a class="collapse-item" href="{{ base_url }}permission/index">Permisos</a>
					<a class="collapse-item" href="{{ base_url }}user/index">Usuarios</a>
					<a class="collapse-item" href="{{ base_url }}user_level/index">Niveles</a></a>
					<a class="collapse-item" href="{{ base_url }}param/index">Parametros</a></a>
					<a class="collapse-item" href="{{ base_url }}query_console/index">Consola sql update</a>
					<a class="collapse-item" href="{{ base_url }}query_console/select_query">Consola sql select</a>
				  </div>
				</div>
			  </li>
		
			  <hr class="sidebar-divider d-none d-md-block">';

			  $html_view = str_replace(
				'{{ admin_menu }}',
				(Session::get('role_id')!=='1'?'':$admin_menu),
				$html_view);


			$html_view = str_replace(
					'{{ base_url }}',
					CoreUtils::base_url(),
					$html_view);
			$html_view = str_replace(
					'{{ profile_icon }}',
					(Session::get('user_profile_photo')?Component::img_to_base64(UPLOADS_DIR.Session::get('user_profile_photo')) 
					:'https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg'),
					$html_view);

			$html_view = str_replace(
					'{{ error_message }}',
					(isset($this->record)&& isset($this->record['error_message'])?
						'<div class="error_msg">'.
							$this->record['error_message'].
						'</div>':''),
					$html_view);

			$html_view = str_replace(
					'{{ app_message }}',
					(isset($this->record)&& isset($this->record['app_message'])?
						'<div class="message">'.
							$this->record['app_message'].
						'</div>':''),
					$html_view);
					
			 $html_view = 
			 	CoreUtils::set_buttons_permissions($this,$filename,$html_view);
			
			$html_view = Translator::translate(
				CoreUtils::get_controller_name($this) . '/' . $filename,
				$html_view);

			$html_view = str_replace(
					'{{ NOTIFICATION_COUNT }}',
					CoreUtils::get_notification_count(),
					$html_view);

			$html_view = str_replace(
					'{{ NOTIFICATION_DIV }}',
					CoreUtils::get_user_notification(),
					$html_view);
			
			$html_view = str_replace(
					'{{ URL_NOTIFICATION }}',
					SERVER_DIR.'notification/show_all',
					$html_view);
				
				return $html_view;
		}
		
		/**
		 * metodo para generar automaticamente los menu hijos
		 * @param type $html_menu 
		 * @param type $parent 
		 * @param type $i 
		 * @return type
		 */
		public function generate_childs_menu($parent,$i){
			$html_menu='<div id="collapse_'.$i.'" class="collapse" '.
				'aria-labelledby="heading_'.$parent['title'].
				'" data-parent="#accordionSidebar">'.
	 			'<div class="bg-white py-2 collapse-inner rounded">';

			$childs = $parent['childs'];

			if(is_array($childs) && count($childs)>0){
				foreach($childs as $child){
					$child_permission = 
						CoreUtils::get_user_permissions_by_menu_id($child['menu_id']);
					if(!isset($child_permission) || 
						(isset($child_permission) && 
							$child_permission['can_read'])){
						$html_menu.='<a class="collapse-item" href="{{ base_url }}'.
							$child['url'].'">'.$child['title'].'</a>';
					}
				/* end child permission check */
				}
			}
			$html_menu.='</div></div>';
			return $html_menu;
		}

		/**
		 * meodo para generar automaticamente el menu padre
		 * @param type $html_menu 
		 * @param type $parent 
		 * @param type $i 
		 * @return type
		 */
		public function generate_parent_menu(array $parent,$i){
			$html_menu='<a class="nav-link collapsed" href="'.
	 		(!array_key_exists ('childs',$parent)?'{{ base_url }}'.$parent['url']:'#')	.'"';
			if(array_key_exists('childs',$parent)){
	 			$html_menu.=' data-toggle="collapse" data-target="#collapse_'.$i.'" 
					aria-expanded="true" aria-controls="collapse_'.$i.'"';
			}
			$html_menu.='><i class="'.$parent['icon'].'"></i><span>'.
			$parent['title'].'</span></a>';

			if(array_key_exists('childs',$parent)){
				$html_menu.= $this->generate_childs_menu($parent,$i);
			}
			return $html_menu;
		}

		/**
		 * metodo para generar automatcamente el menu de la aplicacion
		 * segun los accesos del usuario loggeado
		 * @return type
		 */
		public function get_app_menu(){
			$html_menu = '';
			$menu_data = (new Menu())->get_menu_data();
			$i=0;
			foreach($menu_data as $parent){
				$parent_permission = 
					CoreUtils::get_user_permissions_by_menu_id($parent['menu_id']);
				if(!isset($parent_permission) || 
					(isset($parent_permission) && $parent_permission['can_read'])){
					$i++;
					$html_menu.='<hr class="sidebar-divider">'.
					'<li class="nav-item  active">'.
					$this->generate_parent_menu($parent,$i).'</li>';
				}
				/*end parent permission check*/
			}
		return $html_menu;
		}
		
       
		/*******************************************************/
		
		/**
		* acciones genericas de controlador
		*/
		/**
		* acciones prepare
		*/
		public function init($obj){
			CoreUtils::validate_user_session();
			$this->model = $obj;
			$this->view = new View($this->model);
			$this->view_processor = new ViewProcessor($this->view);
		}
		/**
		* acciones doit crud
		*/
		function action_index($obj,$auto_build=false){
			$this->action_list($obj,$auto_build,'index');
		}
		function action_items($obj,$auto_build=false){
			$this->action_list($obj,$auto_build,'items');
		}
		function action_list($obj,$auto_build=false,$filename){
			$this->init($obj);
			$d['records'] = $this->model->showAllRecords();
			if(method_exists($this->model,'before_render_list')){
				$tmp = $this->model->before_render_list($d["records"]);
				if(isset($tmp))
					$d["records"] = $tmp;
			}
			$this->set($d);
			$this->render($filename,$auto_build);
		}
		function action_create($obj,$post=null,$auto_build=false){
			$this->init($obj);
			$d["record"]['form_action'] = 'Agregar';
			if (isset($post[$this->model->name_fields[0]])){
				if(method_exists($this->model,'before_save')){
					$tmp = $this->model->before_save($post);
					if(isset($tmp))
						$post = $tmp;
				}
				if ($this->model->create($post)){
					if(method_exists($this->model,'after_save')){
						$row = $this->model->get_by_property($post);
						$tmp = $this->model->after_save($post,$row[$this->model->name_fields[0]]);
						if(isset($tmp))
							$post = $tmp;
					}
					header("Location: " . WEBROOT .  $this->model->table_name."/index");
				}
			}
			if(method_exists($this->model,'before_render_form')){
				$tmp = $this->model->before_render_form($d["record"]);
				if(isset($tmp))
					$d["record"] = $tmp;
			}
			$this->set($d);
			$this->render("form",$auto_build);
		}
		function action_edit($id,$obj,$post=null,$auto_build=false){
			$this->init($obj);
			$d["record"] = $this->model->get_by_id($id);
			$d["record"]['form_action'] = 'Editar';
			
			if (isset($post[$this->model->name_fields[0]])){
				if(method_exists($this->model,'before_save')){
					$tmp = $this->model->before_save($post,$id);
					if(isset($tmp))
						$post = $tmp;
				}
				if ($this->model->edit($id,$post)){
					if(method_exists($this->model,'after_save')){
						$tmp = $this->model->after_save($post,$id);
						if(isset($tmp))
							$post = $tmp;
					}
					header("Location: " . WEBROOT .  $this->model->table_name."/index");
				}
			}
			if(method_exists($this->model,'before_render_form')){
				$tmp = $this->model->before_render_form($d["record"],$id);
				if(isset($tmp))
					$d["record"] = $tmp;
			}
			
			$this->set($d);
			$this->render("form",$auto_build);
		}
		function action_delete($id,$obj){
			$this->init($obj);
			if(method_exists($this->model,'before_delete')){
				$this->model->before_delete($id);
			}
			if ($this->model->delete($id)){
				if(method_exists($this->model,'after_delete')){
					$this->model->after_delete($id);
				}
				header("Location: " . WEBROOT .  $this->model->table_name."/index");
			}
		}
    }
?>
