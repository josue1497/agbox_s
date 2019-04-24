<?php
//namespace App\Models;
class User_Level extends Model{
	
	public function __construct(){
		
		parent::__construct('user_level');
		$this->table_label='Nivel de Usuario';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('Id del Nivel del Usuario')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('name_level'))
				->set_label('Nivel del Usuario')
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