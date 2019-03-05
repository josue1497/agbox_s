<?php
//namespace App\Models;
class Permission extends Model{
	
	public function __construct(){
	
		parent::__construct('permission');
		$this->table_label='Permissions';
		
		$this->add_columns(
			array(
				(new Column('id'))
					->set_label('Id del Permiso')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),
					
				(new Column('user_level_id'))
					->set_label('Rol de Usuarios')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User_Level())
					->set_name_key(),

				(new Column('menu_id'))
					->set_label('Opcion de Menu')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Menu())
					->set_name_key(),
					
				(new Column('can_read'))
					->set_label('Permiso de Lectura')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('can_write'))
					->set_label('Permiso de Escritura')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('can_edit'))
					->set_label('Permiso de Edicion')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('can_delete'))
					->set_label('Permiso de Eliminar')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No'))
			)
		);	
		
		$this->init();
	}
}
?>