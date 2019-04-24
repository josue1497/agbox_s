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
					->set_label('Creador')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User()),
				(new Column('title'))
					->set_label('Titulo')
					->set_type(Column::$COLUMN_TYPE_TEXT)
					->set_name_key(),
				(new Column('summary'))
					->set_label('Sumario')
					->set_type(Column::$COLUMN_TYPE_TEXTAREA)
					->set_visible_grid(false),
				(new Column('source_id'))
					->set_label('origen')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Source())
					->set_visible_grid(false),
				(new Column('init_date'))
					->set_label('Fecha Inicial')
					->set_type(Column::$COLUMN_TYPE_DATE)
					->set_visible_grid(false),
				(new Column('finish_date'))
					->set_label('Fecha Final')
					->set_type(Column::$COLUMN_TYPE_DATE)
					->set_visible_grid(false),
				(new Column('note_type_id'))
					->set_label('Tipo')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Note_Type()),
				(new Column('status_id'))
					->set_label('Estatus')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Status()),
				(new Column('date_approved'))
					->set_label('Fecha de Aprobacion')
					->set_type(Column::$COLUMN_TYPE_DATE)
					->set_visible_grid(false),
				(new Column('group_id'))
					->set_label('Grupo')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_visible_grid(false),
				(new Column('performer_id'))
					->set_label('Asignado a')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User())
					->set_visible_grid(false)
			)
		);
		$this->init();
	}
}
?>