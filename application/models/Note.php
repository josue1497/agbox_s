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
				(new Column('user_id'))
					->set_label('User')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User()),
				(new Column('title'))
					->set_label('Title')
					->set_type(Column::$COLUMN_TYPE_TEXT)
					->set_name_key(),
				(new Column('source_id'))
					->set_label('Source')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Source())
					->set_visible_grid(false),
				(new Column('summary'))
					->set_label('Summary')
					->set_type(Column::$COLUMN_TYPE_TEXTAREA)
					->set_visible_grid(false),
				(new Column('init_date'))
					->set_label('Init Date')
					->set_type(Column::$COLUMN_TYPE_DATE)
					->set_visible_grid(false),
				(new Column('finish_date'))
					->set_label('Finish Date')
					->set_type(Column::$COLUMN_TYPE_DATE)
					->set_visible_grid(false),
				(new Column('status_id'))
					->set_label('Status')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Status()),
				(new Column('date_approved'))
					->set_label('Date Approved')
					->set_type(Column::$COLUMN_TYPE_DATE)
					->set_visible_grid(false),
				(new Column('performer_id'))
					->set_label('Performer')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Employee())
					->set_visible_grid(false),
					(new Column('note_type_id'))
					->set_label('Note Type')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Note_Type())
			)
		);
		$this->init();
	}
}
?>