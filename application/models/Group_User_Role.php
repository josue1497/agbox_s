<?php 
/**
* 
*/	
class Group_User_Role extends Model{
    public function __construct(){
        parent::__construct('group_user_role');
        $this->table_label = 'User Role In Group';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Id')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                 (new Column('group_id'))
					->set_label('Group')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Group())
					->set_name_key(),

				 (new Column('user_id'))
					->set_label('User')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User())
					->set_name_key(),

				(new Column('role_id'))
					->set_label('Role')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Role())
					->set_name_key(),
				
             )
        );
    }
}
?>