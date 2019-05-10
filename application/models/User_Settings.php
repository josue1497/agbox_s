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
				
				(new Column('access_level'))
				->set_label('Acceso del Nivel del Usuario')
				->set_type(Column::$COLUMN_TYPE_SELECT)
				->set_values(array(1,2,3))
			)
		);
		
		$this->init();
	}
}
?>