<?php
class Domain extends Model
{

    public function __construct()
    {

        parent::__construct('domain');
        $this->table_label = 'Domains';

        $this->add_columns(
            array(
                (new Column('domain_id'))
                    ->set_label('Domain ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('name'))
                    ->set_label('Domain Name')
                    ->set_name_key()
                    ->set_unike_key(),

                (new Column('description'))
                    ->set_label('Domain Description')
                    ->set_type(Column::$COLUMN_TYPE_TEXTAREA)
                    ->set_visible_grid(false),
                
                (new Column('license'))
                    ->set_label('Domain License')
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_visible_grid(false)


            )
        );

        $this->init();
    }

}
 