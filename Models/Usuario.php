<?php
class Usuario extends Model{
	
	public function __construct(){
	
		parent::__construct('usuario');
		$this->table_label='Usuario';
		
		$this->add_columns(
			array(
				(new Column('id_usuario'))
					->set_label('Id del Usuario')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),

				(new Column('nombre_usuario'))
					->set_label('Nombre de Usuario')
					->set_unike_key()
					->set_name_key(),
					
				(new Column('clave_usuario'))
					->set_label('Clave de Usuario')
					->set_type(Column::$COLUMN_TYPE_PASS)
					->set_visible_grid(false),
				
				(new Column('re_clave_usuario'))
					->set_label('Repita Clave')
					->set_type(Column::$COLUMN_TYPE_PASS)
					->set_table_field_name('clave_usuario')
					->set_column_in_db(false)
					->set_visible_grid(false),
					
				(new Column('id_nivel_usuario'))
					->set_label('Nivel de Usuario')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Nivel_Usuario())
			)
		);	
		
		$this->init();
	}
}
?>