<?php
	/**
	 * 
	 */
	class perfilController extends Controller{

		
		public function perfil(){
			$this->init(new User());
			$this->render("perfil");
		}
	}
?>