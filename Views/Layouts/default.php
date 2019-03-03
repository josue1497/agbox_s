<?php 
	$r = new Request();
    Router::parse($r->url, $r);
	$base_url='';
	
	if($r->real_controller!='' && $r->real_action!=''){
		$base_url.='../';
	}
	if($r->real_action!='' && count($r->real_params)>0){
		$base_url.='../';
	}
?>
<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>G.E. Juana Josefa Vargas</title>
		<link href="<?php echo $base_url;?>Views/Layouts/styles/w3.css" rel="stylesheet">
		<!--<link href="<?php echo $base_url;?>Views/Layouts/styles/bootstrap.3.3.7.min.css" rel="stylesheet">-->
		<link href="<?php echo $base_url;?>Views/Layouts/styles/bootstrap.4.0.0-beta.2.min.css" rel="stylesheet">
		<script src="<?php echo $base_url;?>Views/Layouts/scripts/jquery.3.3.1.min.js"></script>
		<script src="<?php echo $base_url;?>Views/Layouts/scripts/popper.min.js"></script>
		<script src="<?php echo $base_url;?>Views/Layouts/scripts/tooltip.min.js"></script>
		<!--<script src="<?php echo $base_url;?>Views/Layouts/scripts/bootstrap.3.3.7.min.js"></script>-->
		<script src="<?php echo $base_url;?>Views/Layouts/scripts/bootstrap.4.0.0-beta.2.min.js"></script>
	
		<!--<link href="starter-template.css" rel="stylesheet">-->
		<style>
			
			.starter-template {
				padding: 3rem 1.5rem;
				text-align: center;
			}
			
			.nav-item a,.nav-item:hover  {
				text-decoration:none;
			}
		</style>
	</head>
	<body>
	<!-- -->
	 		<img src="<?php echo $base_url;?>Views/Layouts/imgs/banner.jpg" style="width:100%;">

	 <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#">G.E. Juana Josefa Vargas</a>
	  
<?php
if(isset($_SESSION['autenticado']) && $_SESSION['autenticado']==true){
?>

      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample04" style="">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="/<?php echo APP_FOLDER;?>/index/index">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/<?php echo APP_FOLDER;?>/seccion/index">Seccion</a>
          </li>
		  <li class="nav-item">
            <a  class="nav-link" href="/<?php echo APP_FOLDER;?>/docente/index">Docente</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="/<?php echo APP_FOLDER;?>/alumno/index">Alumno</a>
          </li>
		 
		  
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" 
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones de Actualizacion</a>
            <div class="dropdown-menu" aria-labelledby="dropdown04">
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/plantel/index">Plantel</a>
				<!--<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/pais/index">Pais</a>
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/estado/index">Estado</a>
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/ciudad/index">Ciudad</a>-->
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/ocupacion/index">Ocupacion</a>
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/parentesco/index">Parentesco</a>
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/tipo_vivienda/index">Tipo de Vivienda</a>
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/condicion_vivienda/index">Condicion de Vivienda</a>
				<a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/tipo_parto/index">Tipo de Parto</a>              
            </div>
          </li>  
<?php if(isset($_SESSION['acceso_nivel_usuario']) && $_SESSION['acceso_nivel_usuario'] == '3'){ ?>
		  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown05" 
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones del Administrador</a>
            <div class="dropdown-menu" aria-labelledby="dropdown05">
              <a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/nivel_usuario/index">Nivel de Usuario</a>
			  <a class="dropdown-item"  href="/<?php echo APP_FOLDER;?>/usuario/index">Usuario</a>
            </div>
          </li>
<?php } ?>
		  <li class="nav-item">
            <a class="nav-link" href="/<?php echo APP_FOLDER;?>/index/out">Salir</a>
          </li>
        </ul>
      
      </div>
	  
<?php } ?>
    </nav>
	
	<!-- -->
	
	<main role="main" class="container">
		<div class="starter-template">
			<?php
				echo $content_for_layout;
			?>
		</div>
	</main>
	
	<br/>
	<br/>
	<br/>
	<br/>
	
	<footer style="position:fixed;height:50px;width:100%;background-color:#66e;bottom:0;color:white;padding:5px;text-align:center;">
		<b> Sistema de Inscripcion | G.E. Juana Josefa Vargas | &copy; 2018 </b>
	</footer>
	</body>
</html>
