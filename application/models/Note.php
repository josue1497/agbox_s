<?php
class Note extends Model {
		public function __construct(){
		
		parent::__construct('note');
		$this->table_label='Note';
		
		$this->add_columns(
			array(
				(new Column('id'))
					->set_label('Note Id')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),
				//TODO note columns
			)
		);
		$this->init();
	}
}
?>