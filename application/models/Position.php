<?php
class Position extends Model{
    public function __construct()
    {

        parent::__construct('position');
        $this->table_label = 'Position';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Position ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('name'))
                    ->set_label('Position Name')
                    ->set_name_key()
                    ->set_unike_key(),

                (new Column('description'))
                    ->set_label('Position Description')
                    ->set_type(Column::$COLUMN_TYPE_TEXTAREA)
                    ->set_visible_grid(false),
                
                (new Column('domain_id'))
                    ->set_label('Domain')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_visible_grid(false)
                    ->set_fk_entity(new Organization())                
            )
        );

        $this->init();
    }
}