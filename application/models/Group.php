<?php
class Group extends Model
{

    public function __construct()
    {

        parent::__construct('group');
        $this->table_label = 'Groups';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Group ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('name'))
                    ->set_label('Group Name')
                    ->set_name_key()
                    ->set_unike_key()
                    ->set_type(Column::$COLUMN_TYPE_TEXT),

                (new Column('description'))
                    ->set_label('Group Description')
                    ->set_type(Column::$COLUMN_TYPE_TEXTAREA)
                    ->set_visible_grid(false),
      
                (new Column('parent_group_id'))
                    ->set_label('Parent Group')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity($this)
                    ->set_visible_grid(false),
            )
        );

        $this->init();
    }

}
 