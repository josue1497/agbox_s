<?php
	function generate_content($controller,$filename=null,$record=null){

     	/* cargar perfil del usuario actual */
		$record = $controller->model->get_by_id(Session::get('user_id'));

		$user_card = CoreUtils::generate_card(
				$controller->model,
				$controller->auto_build_view('list',null,$record),
				'list',
				$record
			);


		/* grupos a los que esta afiliado el usuario */
		/* afiliaciones */
		$affiliate_model = new Affiliate();
              $group_model = new Group();

		$affs = $affiliate_model->get_by_property(
			array('user_id' => Session::get('user_id')), true);
		// var_dump($affs);die;

		$groups = array();

		if($affs)
			foreach($affs as $aff){
                            /* grupos a los que esta afiliado */
                            
                            $groups[] = $group_model->get_by_id($aff['group_id']);
			}
              // var_dump($groups);

		$c = new Controller();
		$c->init($group_model);


		$groups_card = CoreUtils::generate_card(
				$c->model,
				$c->auto_build_view(
						'list',
						$groups,
						null),
				'list',
				null
                     );
                     
                     return 
			'<div class="container-fluid">'.
			'<div class="row">'.
			$user_card. 
			//'</div>'.
			//'<div class="row">'.
			$groups_card.
			'</div>'.
			'</div>';
}
?>