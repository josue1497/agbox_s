<?php
	function generate_content($controller,$filename=null,$record=null){
		$title='<div class="d-flex align-items-center">Solicita tu afiliación a tus grupos de interés o crea uno nuevo.<a class="btn btn-primary ml-auto" 
		href="'.SERVER_DIR.'groups/create_group"><i class="fas fa-plus"></i></a></div>';
		$html_result=file_get_contents(__DIR__.'/items.html');
	return CoreUtils::put_in_card(
		$html_result,
		$title);
}
?>