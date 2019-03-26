<?php 
	/**
	 * clase para gestionar la creacion de vistas
	 */
	class ViewProcessor {
		var $styles = '';
		var $scripts = '';

		var $topbar = '';
		var $sidebar = '';
		var $footer = '';
		
		var $layout = '';
				
		var $content = array();
				
		public function __construct($view = null){
			$this->view = $view;
		}

		public function set_styles($styles){
			$this->styles = $styles;
			return $this;
		}
		public function get_styles(){
			return $this->styles;
		}

		public function set_scripts($scripts){
			$this->scripts = $scripts;
			return $this;
		}
		public function get_scripts(){
			return $this->scripts;
		}

		public function set_topbar($topbar){
			$this->topbar = $topbar;
			return $this;
		}
		public function get_topbar(){
			return $this->topbar;
		}
			
		public function set_sidebar($sidebar){
			$this->sidebar = $sidebar;
			return $this;
		}
		public function get_sidebar(){
			return $this->sidebar;
		}

		public function set_footer($footer){
			$this->footer = $footer;
			return $this;
		}
		public function get_footer(){
			return $this->footer;
		}
		
		public function set_content($row){
			$this->content = array($row);
			return $this;
		}
		public function add_content($row){
			$this->content[] = $row;
			return $this;
		}
		public function get_content(){
			return $this->content;
		}
		public function parse_content(){
			$result = '';
			foreach($this->get_content() as $row){
				$result .= $row;
			}
			return $result;
		}
		
		public function set_layout($layout){
			$this->layout=$layout;
			return $this;
		}
		public function get_layout(){
			return $this->layout;
		}
			
		public function set_user_data(){
			$user_name = Session::get('user_names');
			if(isset($user_name)){
				$this->set_topbar(str_replace('{{ user_name }}',$user_name,$this->get_topbar()));
			}
			$user_id = Session::get('user_id');
			if(isset($user_id)){
				$this->set_topbar(str_replace('{{ user_id }}',$user_id,$this->get_topbar()));
			}
		}
		
		public function build_view(){
			$html = $this->get_layout();
			
			$this->set_user_data();
			
			$html = str_replace('{{ '.TEMPLATE_NAME.'_styles }}',$this->get_styles(),$html);
			$html = str_replace('{{ '.TEMPLATE_NAME.'_topbar }}',$this->get_topbar(),$html);
			$html = str_replace('{{ '.TEMPLATE_NAME.'_side }}',$this->get_sidebar(),$html);
			$html = str_replace('{{ '.TEMPLATE_NAME.'_content }}',$this->parse_content(),$html);
			$html = str_replace('{{ '.TEMPLATE_NAME.'_scripts }}',$this->get_scripts(),$html);
			$html = str_replace('{{ '.TEMPLATE_NAME.'_scripts }}',$this->get_scripts(),$html);
			$html = str_replace('{{ '.TEMPLATE_NAME.'_footer }}',$this->get_footer(),$html);
			
			return $html;
		}
	}
?>