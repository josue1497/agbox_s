<?php
	function generate_content($controller,$filename=null,$record=null){
		//$this->init(new User()); already loaded in userController/perfil

		/* cargar perfil del usuario actual */
		$record = $controller->model->get_by_id(Session::get('user_id'));

		$user_card = CoreUtils::generate_card(
				$controller->model,
				$controller->auto_build_view('form',null,$record),
				'form',
				$record
			);


		/* grupos a los que esta afiliado el usuario */
		/* afiliaciones */
		$affiliate_model = new Affiliate();
		$group_model = new Group();

		$affs = $affiliate_model->showAllRecords(
			array('user_id' => Session::get('user_id')));
		

		$groups = array();

		if($aff)
			foreach($affs as $aff){
				/* grupos a los que esta afiliado */
				$groups[] = $group_model->showAllRecords(array('id' => $aff['group_id']));
			}


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

		/* notes of user */
		$note_model = new Note();
		$approver_model = new Note_Approver();
		$notes = array();
		
		/* approved or rejected notes for this user */
		$approvers = 
			$approver_model->showAllRecords(array('user_id' => Session::get('user_id')));
		/* if eists */
		if($approvers)
			foreach($approvers as $approver){
				/* map it */
				$notes[] = $note_model->showAllRecords( array( 'id' => $approver['note_id']));
			}
		
		/* notes creatd by this user */
		$user_notes = $note_model->showAllRecords(array('user_id'=>Session::get('user_id')));
		/* if exists */
		if($user_notes)
			foreach($user_notes as $user_note){
				/* check if not already map'ed to prevend repeat notes in array */
				$maped=false;
				foreach($notes as $note){
					if($note['id']==$user_note['id']){
						$maped=true;
					}
				}
				/* if not map'ed then map'it*/
				if($maped==false){
					$notes[] = $user_note;
				}
			}
		
		/* buid view for this component */
		$n = new Controller();
		$n->init($note_model);

		$notes_card = CoreUtils::generate_card(
				$n->model,
				$n->auto_build_view('list',$notes,null),
				'list',
				null
			);


/* update class */

$user_card = str_replace('container', '', $user_card);
$groups_card = str_replace('container', '', $groups_card);

$user_card = str_replace('col-md-12 col-md-offset-2', 'col-lg-6 mb-4', $user_card);
$groups_card = str_replace('col-md-12 col-md-offset-2', 'col-lg-6 mb-4', $groups_card);



		/* return view with 3 cards */
		return 
			//'<div class="container-fluid">'.
			'<div class="row">'.
			$user_card. 
			//'</div>'.
			//'<div class="row">'.
			$groups_card.
			//'</div>'.
			//'<div class="row">'.
			$notes_card.
			//'</div>'.
			'</div>';

/*
<div class="col-lg-6 mb-4">
  <!-- Illustrations -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
    </div>
    <div class="card-body">
      <div class="text-center">
        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">
      </div>
      <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
      <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw →</a>
    </div>
  </div>
</div>
*/
			
	}
?>