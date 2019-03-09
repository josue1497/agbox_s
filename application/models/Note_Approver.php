<?php
class Note_Approver extends Model{
	 public function __construct(){
        parent::__construct('note_approver');
        $this->table_label = 'User Approver';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Id')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                 (new Column('note_id'))
					->set_label('Note')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Note())
					->set_name_key(),

				 (new Column('user_id'))
					->set_label('User')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User())
					->set_name_key()
				
             )
        );
    }
}
?>