<?php
	require_once(ROOT.'Models/Menu.php');
	
    class Controller{
        var $vars = array();
        var $layout = TEMPLATE_NAME;
		var $model;
		var $view;
		
        function set($d){
            $this->vars = array_merge($this->vars, $d);
        }
		
		function get_file_content($file_url){
			if(is_file($file_url))
				return file_get_contents($file_url);
			return '';
		}
		
		function get_template_file_content($file_url=''){
			return $this->get_file_content(
				ROOT . "Views/Layouts/" . 
					$this->layout . 
					(($file_url!='')?('/'.$file_url):'') .
					'.php'
			);
		}
		
		function get_view_file_content($file_name){
			return $this->get_file_content(
				ROOT . "Views/" . 
					ucfirst(str_replace('Controller', '', get_class($this))) . '/' . 
					$file_name . 
					'.php'
				);
		}
		
		function validate_user_session(){
			if (Session::check('logged_in')) {
				$username = Session::get('username');
				$email =Session::get('email');
			} else {
				header("location: ".base_url()."index/login");
			}
		}

		function build_view($html_topbar,$html_side,$html_content){
			$html_view = $this->get_template_file_content('');

			$html_view =  str_replace(
					'{{ '.$this->layout.'_styles }}',
					$this->get_template_file_content('styles'),
					$html_view);
			
			/* establecer nombre de usuarioen topbar */
			$user_name='';
			if(Session::get('user_email')){
				/*$row = (new Usuario())
					->get_by_property(array('nombre_usuario'=>Session::get('user_email')));
					
				$user_name = $row['nombre_usuario'];
				*/
				$user_name=Session::get('user_email');
			}
			$html_topbar = str_replace('{{ user_name }}',$user_name,$html_topbar);

			$html_view =  str_replace(
					'{{ '.$this->layout.'_topbar }}',
					$html_topbar,
					$html_view);

			$html_view =  str_replace(
					'{{ '.$this->layout.'_side }}',
					$html_side,
					$html_view);

			$html_view =  str_replace(
				'{{ '.$this->layout.'_content }}',
				$html_content,
				$html_view);
			
			$html_view =  str_replace(
					'{{ '.$this->layout.'_scripts }}',
					$this->get_template_file_content('scripts'),
					$html_view);
			
			$html_view =  str_replace(
					'{{ '.$this->layout.'_footer }}',
					$this->get_template_file_content('footer'),
					$html_view);

			return $html_view;
		}
		
        function render($filename,$auto_build=false){
            extract($this->vars);
			$html_topbar ='';
			$html_side = '';
			$html_content='';
			if(Session::get('log_out')){
				$html_content=$this->get_file_content(ROOT . "Views/Index/login.php");
			}else{
				$html_topbar = $this->get_template_file_content('topbar');
				$html_side = $this->get_template_file_content('side');	
				if($auto_build){
					if($filename == 'index'){
						$html_content = $this->view->auto_build_list($this->view->auto_build_list_content($records),$records);
					}else if($filename='form'){
						$html_content = $this->view->auto_build_form($this->view->auto_build_form_content($record),$record);
					}
				}else{
					$html_content = $this->get_view_file_content($filename);
					if($html_content=='')
						$html_content = $this->get_file_content(ROOT . "Views/Index/index");
					else{
						if(isset($this->view)){
							$html_content = str_replace(
								'{{ auto_build_form_content }}',
								$this->view->auto_build_form_content($record),
								$html_content);
						}
					}
				}
			}
			
			/* las vistas del controlador index se genraran sin card*/
			if(get_class($this)!='indexController')
				$html_content='
					<div class="container">
						<div class="col-md-8 col-md-offset-2">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
								 <h6 class="m-0 font-weight-bold text-primary">{{ title_module }}</h6>
								</div>
								<div class="card-body">
									<div id="dynamic_content">
										'.$html_content.'
									</div>
								</div>
							</div>
						</div>
					</div>';
			
			$html_view = $this->build_view(
					$html_topbar,
					$html_side,
					$html_content);
			
			$html_view = str_replace(
					'{{ name_module }}',
					$this->model->table_name.'_module',
					$html_view);

			$html_view = str_replace(
					'{{ title_module }}',
					(isset($record['form_action'])?$record['form_action']:'').' '.
					$this->model->table_label,
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

			$html_view = str_replace(
					'{{ base_url }}',
					base_url(),
					$html_view);
			
			
			/* render */
			echo $html_view;
        }
		
		public function get_app_menu(){
			$html_menu = '';
			$menu_data = (new Menu())->get_menu_data();
			$i=0;
			foreach($menu_data as $parent){
$i++;
$html_menu.='<hr class="sidebar-divider">
<li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" 
		data-target="#collapse_'.$i.'" 
		aria-expanded="true" aria-controls="collapse_'.$i.'">
		<i class="'.$parent['icon_menu'].'"></i>
		<span>'.$parent['titulo_menu'].'</span>
	</a>

	<div id="collapse_'.$i.'" class="collapse" 
		aria-labelledby="heading_'.$parent['titulo_menu'].'" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">';

$childs = $parent['childs'];
if(is_array($childs))
	foreach($childs as $child){
		$html_menu.='<a class="collapse-item" href="{{ base_url }}'.
			$child['url_menu'].'">'.$child['titulo_menu'].'</a>';
	}
		
$html_menu.='</div>
	</div>
</li>';
			}
		return $html_menu;
		}
		
        private function secure_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        protected function secure_form($form){
            foreach ($form as $key => $value){
                $form[$key] = $this->secure_input($value);
            }
        }
		
		/*******************************************************/
		
		/**
		* acciones genericas de controlador
		*/
		public function init($obj){
			$this->validate_user_session();
			$this->model = $obj;
			$this->view = new View($this->model);
		}
		
		function action_index($obj,$auto_build=false){
			$this->init($obj);
			$d['records'] = $this->model->showAllRecords();
			$this->set($d);
			$this->render("index",$auto_build);
		}
		function action_create($obj,$post=null,$auto_build=false){
			$this->init($obj);
			$d["record"]['form_action'] = 'Agregar';
			if (isset($post[$this->model->name_fields[0]])){
				if ($this->model->create($post)){
					header("Location: " . WEBROOT .  $this->model->table_name."/index");
				}
			}
			$this->set($d);
			$this->render("form",$auto_build);
		}
		function action_edit($id,$obj,$post=null,$auto_build=false){
			$this->init($obj);
			$d["record"] = $this->model->get_by_id($id);
			$d["record"]['form_action'] = 'Editar';
			if (isset($post[$this->model->name_fields[0]])){
				if ($this->model->edit($id,$post)){
					header("Location: " . WEBROOT .  $this->model->table_name."/index");
				}
			}
			$this->set($d);
			$this->render("form",$auto_build);
		}
		function action_delete($id,$obj){
			$this->init($obj);
			if ($this->model->delete($id)){
				header("Location: " . WEBROOT .  $this->model->table_name."/index");
			}
		}
    }
?>