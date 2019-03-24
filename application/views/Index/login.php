<?php 
	function generate_content($controller,$filename=null,$record=null){
	return CoreUtils::put_in_card('
<html>
	<head>
		<title>login_form_title_trl</title>
		<link rel="stylesheet" type="text/css" href="{{ base_url }}application/views/Layouts/styles/style.css">
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway" rel="stylesheet" type="text/css">
	</head>
	<body>

		{{ app_message }}
		
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
                    <h1 class="h4 text-gray-900 mb-4">welcome_msg_trl</h1>
                  </div>
                  <form class="user" action="#" method="post" id="form_log_in">

                  	{{ error_message }}
                  	
				  <input type="hidden" name="login_user" value="1"/>
                    <div class="form-group">
					<!--type email-->
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="enter_email_msg_trl"  name="email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="enter_password_msg_trl"
					  name="password">
                    </div>
					<div class="form-group">
						<select class="form-control form-control-select"  name="language">
							<option value="lan_en" selected >select_lan_trl</option>
							<option value="lan_en">select_en_trl</option>
							<option value="lan_es">select_es_trl</option>
						</select>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        	<input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck"> enter_rememberme_msg_trl</label>
                      </div>
                    </div>
					
					<input type="submit" class="btn btn-primary btn-user btn-block" value="login_button_msg_trl" name="login">
                    <hr>
                    <a href="#" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> login_google_trl
                    </a>
                    <a href="#" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> login_facebook_trl
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="#">forgot_password_trl</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

	</body>
</html>','');
?>
