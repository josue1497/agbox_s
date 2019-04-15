<?php
define('TEMPLATE_NAME','intelix_todo');
define('APP_NAME','.:: A B X ::.');
define("PATH_ROOT", dirname(__FILE__));
define('APP_FOLDER','abx');
define('VIEWS_DIR', ROOT . "application/views/");
define('LAYOUT_DIR', VIEWS_DIR . "Layouts/");
define('JS_DIR', LAYOUT_DIR . "scripts/");
define('CSS_DIR', LAYOUT_DIR . "styles/");
define('IMG_DIR', LAYOUT_DIR . "imgs/");
define('UPLOADS_DIR', LAYOUT_DIR . "imgs/uploads/");
define('VENDOR_DIR', LAYOUT_DIR . "vendor/");
define('MODELS_DIR', ROOT . "application/models/");
define('SERVER_PORT','8090');
define('SERVER_DIR', "http://".$_SERVER['SERVER_NAME'].SERVER_PORT."/".APP_FOLDER."/");

/* constantes de la db */
define('DB_HOST','localhost');
define('DB_NAME','abx_db');
define('DB_USER','abxuser');
define('DB_PASS','12345678');


require_once(ROOT.'system/core/Autoloader.php');
Autoloader::register();
?>