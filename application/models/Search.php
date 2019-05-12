<?php 
class Search extends Model{
    public function __construct(){
        parent::__construct('search');
        $this->table_label = 'Search';
        $this->add_columns(array());
		$this->init();
	}
}