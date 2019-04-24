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
				->set_visible_grid(false),

				(new Column('value'))
				->set_label('Value')
				->set_type(Column::$COLUMN_TYPE_TEXT)
				->set_visible_grid(false)
			)
		);

		$this->init();
	}

	public static function get_type_id($status){
		$status_record=(new Note_Type)->findByPoperty(array('value'=>$status));
		return $status_record['id'];
	}

	public static function get_assignment_status(){
		return Note_type::get_type_id('AS');
	}

	public static function get_commitment_status(){
		return Note_type::get_type_id('CO');
	}

	public static function get_suggested_point_status(){
		return Note_type::get_type_id('SP');
	}

	public static function get_agenda_point_status(){
		return Note_type::get_type_id('AP');
	}
}
?>