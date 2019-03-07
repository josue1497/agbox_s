<?php
/**
 * clase para gestionar la base de datos
 */
	class Database{
		private static $bdd = null;
		
		private function __construct() {
		}
		/**
		 * obtiene la conexion activa a la base de datos, 
		 * o la genera si no existe
		 * 
		 * @return type
		 */
		public static function getBdd() {
			if(is_null(self::$bdd)) {
				self::$bdd = 
					new PDO("mysql:host=".DB_HOST.":3307;dbname=".DB_NAME,DB_USER,DB_PASS, NULL);
			}
			return self::$bdd;
		}
	}
?>