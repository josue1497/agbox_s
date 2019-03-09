<?php
 //namespace App\Models;
//use App\Models\Nivel_Usuario;
class User extends Model
{

	public function __construct()
	{

		parent::__construct('user');
		$this->table_label = 'Users';

		$this->add_columns(
			array(
				(new Column('id'))
					->set_label('Id del Usuario')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),

				(new Column('names'))
					->set_label('Nombres')
					->set_unike_key()
					->set_name_key(),

				(new Column('lastnames'))
					->set_label('Apellidos')
					->set_unike_key()
					->set_name_key(),

				(new Column('mail'))
					->set_label('E-Mail')
					->set_type(Column::$COLUMN_TYPE_EMAIL)
					->set_unike_key()
					->set_name_key(),

				(new Column('username'))
					->set_label('Usuario')
					->set_unike_key()
					->set_name_key(),

				(new Column('password'))
					->set_label('Clave de Usuario')
					->set_type(Column::$COLUMN_TYPE_PASS)
					->set_visible_grid(false),

				(new Column('re_password'))
					->set_label('Repita Clave')
					->set_type(Column::$COLUMN_TYPE_PASS)
					->set_table_field_name('password')
					->set_column_in_db(false)
					->set_visible_grid(false),

				(new Column('user_level_id'))
					->set_label('Nivel de Usuario')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User_Level()),
				
					(new Column('is_visitor'))
					->set_label('Is Visitor?')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No'))

			)
		);

		$this->init();
	}
}
 