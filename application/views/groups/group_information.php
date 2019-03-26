<?php
	function generate_content($controller,$filename=null,$record=null){
       return $controller->action_items(new Group(),true, 'items');

}
?>