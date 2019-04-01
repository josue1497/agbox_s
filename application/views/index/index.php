<?php 
	function generate_content($controller,$filename=null,$record=null){

    $html_result = file_get_contents(__DIR__ . '/index.html');
    
	  return $html_result;
}
?>