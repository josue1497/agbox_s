<?php
	function generate_content($controller,$filename=null,$record=null){
	return CoreUtils::put_in_card(
		'<div id="app">
			<div class="row">
				<div class="col text-center" v-show="load"><h1>Loading...</h1></div>
				<div class="col text-center" v-show="fill"><h1>Data Not Found!</h1></div>
				<div v-for="group in groups">
					<affiliate-component :name="group.name" :group_photo="group.group_photo" :user="group.user" :id="group.id"></affiliate-component>
				</div>
			</div> 
		</div>',
		'Afiliación a Grupos');
}
?>