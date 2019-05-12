<?php
/**
 * controlador para el crud de menu
 */
class searchController extends Controller{
	public function query(){
		if(isset($_POST['q'])&& !empty($_POST['q'])){
			$this->init(new Search());
			$d["record"] = $_POST;
			$this->set($d);
			$this->render('search_box');
		}else{
			$this->index();
		}
	}
	
	public function index(){
		header("location: ".CoreUtils::base_url().'index/index');
	}
}
?>