<?php
class Note_Type extends Model{
	public function __construct(){
		
		parent::__construct('note_type');
		$this->table_label='Note Type';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('ID')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('name'))
				->set_label('Note Type')
				->set_name_key()
				->set_unike_key(),
				
				(new Column('description'))
				->set_label('Description')
				->set_type(Column::$COLUMN_TYPE_TEXTAREA)
				->set_visible_grid(false)
			)
		);
	}
}
?>