<!-- Sidebar -->
    <ul class="navbar-nav  sidebar sidebar-light accordion toggled" id="accordionSidebar">
<!-- bg-gradient-primary sidebar-dark -->
	
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <!--<i class="fas fa-laugh-wink"></i>-->
		  <img  class="small-logo" src="{{ base_url }}Views/Layouts/imgs/isotipo.png" style="width:100%;"/>
        </div>
        <!--<div class="sidebar-brand-text mx-3">SB Admin <sup>2</div>-->
		
		  <img class="logo" src="{{ base_url }}Views/Layouts/imgs/imagotipo2.png" style="display:none;width:100%;"/>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ base_url }}index/index">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

     
	<!-- -->
	  {{ app_menu }}
	<!---->
      <!-- Divider -->
		<hr class="sidebar-divider"> 
	   <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAjustes" aria-expanded="true" aria-controls="collapseAjustes">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Ajustes</span>
        </a>
        <div id="collapseAjustes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="#">Preferencias</a>
            <a class="collapse-item" href="#">Ajustes</a>
            <a class="collapse-item" href="{{ base_url }}menu/index">Menu</a>
            <a class="collapse-item" href="{{ base_url }}permiso/index">Permisos</a>
            <a class="collapse-item" href="{{ base_url }}usuario/index">Usuarios</a>
            <a class="collapse-item" href="{{ base_url }}nivel_usuario/index">Roles</a>

          </div>
        </div>
      </li>

      <!-- Nav Item - Tables - - >
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>
	  <!-- -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" onclick="
			if($('.small-logo').is(':visible')){
				$('.small-logo').hide();$('.logo').show();
			}else{
				$('.small-logo').show();$('.logo').hide();
			}
		"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
