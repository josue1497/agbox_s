<?php
	/**
	 * clase para gestionar traducciones en la aplicacion
	 */
	class Translator{
		
		/**
		 * metodo para obtener el archivo de traducciones segun el idioma con 
		 * el que el usuario ha iniciado sesion. por defecto devuelve el 
		 * idioma ingles
		 * 
		 * @param type $lan 
		 * @return type
		 */
		public static function get_lan_file($lan){
			$lan_file = 'Lan_English';
			switch($lan){
				case 'lan_es':
					$lan_file='Lan_Spanish';
				break;
				case 'lan_en':
				default:
					$lan_file='Lan_English'; 
				break;
			}
			return $lan_file;
		}

		/**
		 * metodo que devuelve array de traducciones para una vista 
		 * especifica
		 * 
		 * @param type $lan_obj 
		 * @param type $url_menu 
		 * @return type
		 */
		public static function get_translation_for_view($lan_obj,$url_menu){
			$tmp  = $lan_obj->get_translation();
			if(isset($tmp[$url_menu]))
				return $tmp[$url_menu];
			return array();
		}

		/**
		 * metodo para traducir el contenido generado de una vista
		 * 
		 * @param $url ruta de menu del controlador/ista (index/login)
		 * @param string $html_view contenido generado de la vista
		 * @return string ista generada traducida 
		 */
		public static function translate($url,$html_view){
			$lan_file = self::get_lan_file(Session::get('lan'));
			$lan_obj = new $lan_file();
			$lan_view = self::get_translation_for_view($lan_obj,strtolower($url));
			
			if(count($lan_view)>0)
				foreach($lan_view as $key => $value){
					$html_view = str_replace($key, $value, $html_view);
				}
			return $html_view;
		}
	}
?>