<?php 
	function generate_content($controller,$filename=null,$record=null){
	return 
'

		{{ app_message }}
    <div class="d-flex align-items-center" style="height: 90vh;">
    <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image2r">
              		<img src="{{ base_url }}application/views/Layouts/imgs/int_2.jpg"
              			 style="height:100%;width:100%;"/>
              	</div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">¡Bienvenido!</h1>
                  </div>
                  <form class="user" action="#" method="post" id="form_log_in">

                  	{{ error_message }}
                  	
				  <input type="hidden" name="login_user" value="1"/>
                    <div class="form-group">
					<!--type email-->
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Correo Electronico"  name="email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Contraseña"
					  name="password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        	<input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck"> Recuerdame</label>
                      </div>
                    </div>
					
					<input type="submit" class="btn btn-primary btn-user btn-block" value="Iniciar Sesion" name="login">
                    <hr>
                  <div class="text-center">
                    <a class="small" href="#">¿Olvido su Contraseña?</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
    </div>
  ';
}
?>
