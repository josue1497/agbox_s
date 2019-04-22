<?php
class Source extends Model{
	public function __construct(){
		
		parent::__construct('source');
		$this->table_label='Source';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('ID')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('title'))
				->set_label('Source Name')
				->set_name_key()
				->set_unike_key(),
				
				(new Column('description'))
				->set_label('Description')
				->set_type(Column::$COLUMN_TYPE_TEXTAREA)
				->set_visible_grid(false)
			)
		);

		$this->init();
	}
}
?>