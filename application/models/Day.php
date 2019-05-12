<?php
class Day extends Model{
	public function __construct(){
		
		parent::__construct('day');
		$this->table_label='Day';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('ID')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('name'))
				->set_label('nombre')
				->set_name_key(),
				
				(new Column('value'))
				->set_label('value')
                ->set_visible_grid(false)
                ->set_unike_key()
			)
		);

		$this->init();
	}
}
?>