<?php
class Status extends Model{
	public function __construct(){
		
		parent::__construct('status');
		$this->table_label='Status';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('ID')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('name'))
				->set_label('Status Name')
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

	public static function get_status_id($status){
		$status_record=(new Status)->findByPoperty(array('value'=>$status));
		return $status_record['id'];
	}

	public static function get_complete_status(){
		return Status::get_status_id('CO');
	}

	public static function get_pending_status(){
		return Status::get_status_id('P');
	}

	public static function get_close_status(){
		return Status::get_status_id('C');
	}
}
?>