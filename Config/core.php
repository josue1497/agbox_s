<?php
	/* constantes de la app */
	define('TEMPLATE_NAME','intelix_todo');
	define('APP_NAME','.:: A B X ::.');
	define('APP_FOLDER','abx_app');

	/* constantes de la db */
	define('DB_HOST','localhost');
	define('DB_NAME','abx_db');
	define('DB_USER','root');
	define('DB_PASS','12345678');

	/* manejador de sesion */
	require(ROOT . "Core/Session.php");
	
	/* manejo de framerwork, carga de controladores, parseo de url, etc */
	require(ROOT . 'Config/Framework/router.php');
	require(ROOT . 'Config/Framework/request.php');
	require(ROOT . 'Config/Framework/dispatcher.php');
	
	/* configuracion de la db */
	require(ROOT . "Core/DB.php");
	
	/* creacion de componentes html */
	require(ROOT . "Core/Component.php");
	
	/* columnas de los modelos */
	require(ROOT . "Core/Column.php");
	
	/* modelo base*/
	require(ROOT . "Core/Model.php");
	
	/* controlador base */
	require(ROOT . "Core/Controller.php");
	
	/* manejador de vista base */
	require(ROOT . "Core/View.php");
	
?>