<?php
//namespace App\Models;
//use App\Models\Nivel_Usuario;
class User extends Model{
	
	public function __construct(){
	
		parent::__construct('user');
		$this->table_label='Users';
		
		$this->add_columns(
			array(
				(new Column('id'))
					->set_label('Id del Usuario')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),

				(new Column('username'))
					->set_label('Nombre de Usuario')
					->set_unike_key()
					->set_name_key(),
					
				(new Column('password'))
					->set_label('Clave de Usuario')
					->set_type(Column::$COLUMN_TYPE_PASS)
					->set_visible_grid(false),
				
				(new Column('re_password'))
					->set_label('Repita Clave')
					->set_type(Column::$COLUMN_TYPE_PASS)
					->set_table_field_name('clave_usuario')
					->set_column_in_db(false)
					->set_visible_grid(false),
					
				(new Column('user_level_id'))
					->set_label('Nivel de Usuario')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User_Level())
			)
		);	
		
		$this->init();
	}
}
?>