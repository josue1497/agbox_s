<?php
	/* constantes de la app */
	define('TEMPLATE_NAME','intelix_todo');
	define('APP_NAME','.:: A B X ::.');
	define('APP_FOLDER','abx_app');
	define('VIEWS_DIR', ROOT . "Views/");
	define('LAYOUT_DIR', VIEWS_DIR . "Layouts/");

	/* constantes de la db */
	define('DB_HOST','localhost');
	define('DB_NAME','abx_db');
	define('DB_USER','root');
	define('DB_PASS','12345678');

	/* manejador de sesion */
	require_once(ROOT . "Core/Session.php");
	
	/* manejo de framerwork, carga de controladores, parseo de url, etc */
	require_once(ROOT . 'Config/Framework/router.php');
	require_once(ROOT . 'Config/Framework/request.php');
	require_once(ROOT . 'Config/Framework/dispatcher.php');
	
	/* configuracion de la db */
	require_once(ROOT . "Core/DB.php");
	
	/* creacion de componentes html */
	require_once(ROOT . "Core/Component.php");
	
	/* columnas de los modelos */
	require_once(ROOT . "Core/Column.php");
	
	/* modelo base*/
	require_once(ROOT . "Core/Model.php");
	
	/* manejador de vista base */
	require_once(ROOT . "Core/View.php");

	/* utilitarios base */
	require_once(ROOT . "Core/CoreUtils.php");
	
	/* controlador base */
	require_once(ROOT . "Core/Controller.php");
	
?>