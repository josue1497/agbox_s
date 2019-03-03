<?php
class Permiso extends Model{
	
	public function __construct(){
	
		parent::__construct('permiso');
		$this->table_label='Permisos';
		
		$this->add_columns(
			array(
				(new Column('id_permiso'))
					->set_label('Id del Permiso')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),
					
				(new Column('id_nivel_usuario'))
					->set_label('Rol de Usuarios')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Nivel_Usuario())
					->set_name_key(),

				(new Column('id_menu'))
					->set_label('Opcion de Menu')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Menu())
					->set_name_key(),
					
				(new Column('leer_permiso'))
					->set_label('Permiso de Lectura')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('escribir_permiso'))
					->set_label('Permiso de Escritura')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('editar_permiso'))
					->set_label('Permiso de Edicion')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('eliminar_permiso'))
					->set_label('Permiso de Eliminar')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No'))
			)
		);	
		
		$this->init();
	}
}
?>