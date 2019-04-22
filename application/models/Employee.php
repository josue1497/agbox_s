<?php
class Employee extends Model{
    public function __construct()
    {

        parent::__construct('employee');
        $this->table_label = 'Employee';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Employee ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('name'))
                    ->set_label('Employee Name')
                    ->set_name_key()
                    ->set_unike_key(),

                (new Column('description'))
                    ->set_label('Employee Description')
                    ->set_type(Column::$COLUMN_TYPE_TEXTAREA)
                    ->set_visible_grid(false),
                
                (new Column('position'))
                    ->set_label('Position')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_visible_grid(false)
                    ->set_fk_entity(new Position())                
            )
        );

        $this->init();
    }
}