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
		
        function set($d){
            $this->vars = array_merge($this->vars, $d);
        }

		function build_view($html_topbar,$html_side,$html_content){
			$html_view = CoreUtils::get_layout_template_content('',$this->layout);

			$html_view =  str_replace(
					'{{ '.$this->layout.'_styles }}',
					CoreUtils::get_layout_template_content('styles',$this->layout),
					$html_view);
			
			/* establecer nombre de usuarioen topbar */
			$user_name='';
			if(Session::get('user_email')){
				$user_name = Session::get('user_email');
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
					CoreUtils::get_layout_template_content('scripts',$this->layout),
					$html_view);
			
			$html_view =  str_replace(
					'{{ '.$this->layout.'_footer }}',
					CoreUtils::get_layout_template_content('footer',$this->layout),
					$html_view);

			return $html_view;
		}
		
        function render($filename,$auto_build=false){
            extract($this->vars);
			$html_topbar ='';
			$html_side = '';
			$html_content='';
			if(Session::get('log_out')){
				$html_content=CoreUtils::get_view_file_content('login',$this);
			}else{
				$tmp = CoreUtils::get_user_permissions_by_controller($this,$filename);
				if(isset($tmp) && isset($tmp['id'])){
					$this->model->crud_config = $tmp;
				}

				$html_topbar = CoreUtils::get_layout_template_content('topbar',$this->layout);
				$html_side = CoreUtils::get_layout_template_content('side',$this->layout);	
				if($auto_build){
					if($filename == 'index'){
						$html_content = $this->view->auto_build_list($this->view->auto_build_list_content($records),$records);
					}else if($filename='form'){
						$html_content = $this->view->auto_build_form($this->view->auto_build_form_content($record),$record);
					}
				}else{
					$html_content = CoreUtils::get_view_file_content($filename,$this);
					if($html_content==''){
						$html_content = CoreUtils::get_view_file_content('index',new indexController());
					}
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
			
			/* las vistas del controlador index se genraran sin card */
			if(get_class($this)!='indexController')
				$html_content = CoreUtils::put_in_card($html_content,"{{ title_module }}");
			
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
					CoreUtils::base_url(),
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

			/* render */
			echo $html_view;
        }
		
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
$html_menu.='<hr class="sidebar-divider">
<li class="nav-item  active">
	<a class="nav-link collapsed" href="';
	$html_menu.= (!array_key_exists ('childs',$parent)?'{{ base_url }}'.$parent['url'].'"':'#"')
	.' data-toggle="collapse" 
		data-target="#collapse_'.$i.'" 
		aria-expanded="true" aria-controls="collapse_'.$i.'">
		<i class="'.$parent['icon'].'"></i>
		<span>'.$parent['title'].'</span>
	</a>
	<div id="collapse_'.$i.'" class="collapse" 
		aria-labelledby="heading_'.$parent['title'].'" data-parent="#accordionSidebar">
	  <div class="bg-white py-2 collapse-inner rounded">';

$childs = array_key_exists ('childs',$parent)?$parent['childs']:[];
if(is_array($childs))
	foreach($childs as $child){
		$child_permission = 
					CoreUtils::get_user_permissions_by_menu_id($child['menu_id']);
		if(!isset($child_permission) || 
			(isset($child_permission) && $child_permission['can_read'])){
					$html_menu.='<a class="collapse-item" href="{{ base_url }}'.
			$child['url'].'">'.$child['title'].'</a>';
		}
		/* end child permission check */
	}
		
$html_menu.='</div>
	</div>
</li>';
}
/*end parent permission check*/
			}
		return $html_menu;
		}
		
       
		/*******************************************************/
		
		/**
		* acciones genericas de controlador
		*/
		public function init($obj){
			CoreUtils::validate_user_session();
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