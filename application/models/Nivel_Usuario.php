<?php
//namespace App\Models;
class Nivel_Usuario extends Model{
	
	public function __construct(){
		
		parent::__construct('nivel_usuario');
		$this->table_label='Nivel de Usuario';
		
		$this->add_columns(
			array(
				(new Column('id_nivel_usuario'))
				->set_label('Id del Nivel del Usuario')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('nombre_nivel_usuario'))
				->set_label('Nivel del Usuario')
				->set_name_key(),
				
				(new Column('acceso_nivel_usuario'))
				->set_label('Acceso del Nivel del Usuario')
				->set_type(Column::$COLUMN_TYPE_SELECT)
				->set_values(array(1,2,3))
			)
		);
		
		$this->init();
	}
}
?>