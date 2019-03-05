<?php 
	/**
	 * clase de traducciones para idioma ingles
	 */
	class Lan_English{
		/**
		 * metodo que devuelve aray de traducciones para 
		 * cada vista de cada controlador
		 * 
		 * @return type
		 */
		public function get_translation(){
			return  array(
				'index/login' => array(
					'login_form_title_trl' => 'Login Form',
					'welcome_msg_trl' => 'Welcome!',
					'enter_email_msg_trl' => 'Enter Email Address...',
					'enter_password_msg_trl' => 'Password',
					'enter_rememberme_msg_trl' => 'Remember Me',
					'login_button_msg_trl'=>'Login',
					'login_google_trl'=>'Login with Google',
					'login_facebook_trl'=>'Login with Facebook',
					'forgot_password_trl'=>'Forgot Password?',
					'select_lan_trl'=>'Select language',
					'select_en_trl'=>'English',
					'select_es_trl'=>'Espa&ntilde;ol',
					'error_msg_password'=>'The password entered is incorrect.',
					'error_msg_email'=>'The email entered is not registered.'

				)
			);
		}
	}
?>