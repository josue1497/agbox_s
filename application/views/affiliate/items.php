<?php
	function generate_content($controller,$filename=null,$record=null){
		$title='<div class="d-flex">Solicita tu afiliación a tus grupos de interes o crea uno nuevo.<a class="btn btn-primary ml-auto" 
		href="'.SERVER_DIR.'groups/create_group"><i class="fas fa-plus"></i></a></div>';
	return CoreUtils::put_in_card(
		'<div id="app">
			<div class="row">
				<div class="col-md-6 text-center" v-show="load"><h1>Loading...</h1></div>
				<div class="col-md-6 text-center" v-show="fill"><h1>Data Not Found!</h1></div>
				<div v-for="group in groups">
					<affiliate-component :name="group.name" :group_photo="group.group_photo" :user="group.user" :id="group.id"></affiliate-component>
				</div>
			</div> 
		</div>',
		$title);
}
?>