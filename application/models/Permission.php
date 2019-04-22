<?php
//namespace App\Models;
class Permission extends Model{
	
	public function __construct(){
	
		parent::__construct('permission');
		$this->table_label='Permissions';
		
		$this->add_columns(
			array(
				(new Column('id'))
					->set_label('Permission Id')
					->set_primary_key()
					->set_auto_increment()
					->set_visible_grid(false)
					->set_visible_form(false),
					
				(new Column('user_level_id'))
					->set_label('User Level')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User_Level())
					->set_name_key(),

				(new Column('menu_id'))
					->set_label('Menu Option')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Menu())
					->set_name_key(),
					
				(new Column('can_read'))
					->set_label('Read Permission')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('can_write'))
					->set_label('Write Permission')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('can_edit'))
					->set_label('Edit Permission')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
				
				(new Column('can_delete'))
					->set_label('Delete Permission')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No'))
			)
		);	
		
		$this->init();
	}
}
?>