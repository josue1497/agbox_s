<?php
//namespace App\Config;
	
	/* manejador de sesion * /
	require_once(ROOT . "Core/Session.php");
	
	/* manejo de framerwork, carga de controladores, parseo de url, etc * /
	require_once(ROOT . 'Config/Framework/router.php');
	require_once(ROOT . 'Config/Framework/request.php');
	require_once(ROOT . 'Config/Framework/dispatcher.php');
	
	/* configuracion de la db * /
	require_once(ROOT . "Core/DB.php");
	
	/* creacion de componentes html * /
	require_once(ROOT . "Core/Component.php");
	
	/* columnas de los modelos * /
	require_once(ROOT . "Core/Column.php");
	
	/* modelo base* /
	require_once(ROOT . "Core/Model.php");
	
	/* manejador de vista base * /
	require_once(ROOT . "Core/View.php");

	/* utilitarios base * / 
	require_once(ROOT . "Core/CoreUtils.php");

	//CoreUtils::get_models_to_sql();

	/* controlador base * /
	require_once(ROOT . "Core/Controller.php");
	/**/
?>