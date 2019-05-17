<?php
class User_Settings extends Model{
	
	public function __construct(){
		
		parent::__construct('user_settings');
		$this->table_label='Parametros de la Aplicacion';
		//TODO tabla para configuracion de aplicacion
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('#')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('user_id'))
                ->set_label('Usuario')
                ->set_type(Column::$COLUMN_TYPE_SELECT)
                ->set_fk_entity(new User())
				->set_name_key(),

				(new Column('language_id'))
					->set_label('idioma')
					->set_visible_grid(false)
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Language()),

				(new Column('date_format_id'))
					->set_label('Formato de fecha')
					->set_visible_grid(false)
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Date_Format()),
				
				(new Column('date_format_short_id'))
					->set_label('Formato de fecha (corto)')
					->set_visible_grid(false)
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Date_Format()),

				(new Column('time_zone'))
					->set_label('Zona Horaria')
					->set_visible_grid(false)
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(DateTimeZone::listIdentifiers()),
				
				(new Column('first_day_week_id'))
					->set_label('Primer dia de la Semana')
					->set_visible_grid(false)
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Day()),
			)
		);
		
		$this->init();
	}
}
