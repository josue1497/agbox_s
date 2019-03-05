<?php
	class Database{
		private static $bdd = null;
		
		private function __construct() {
		}
		public static function getBdd() {
			if(is_null(self::$bdd)) {
				self::$bdd = 
					new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
			}
			return self::$bdd;
		}
	}
?>