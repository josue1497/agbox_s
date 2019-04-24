<?php
class Param extends Model
{

    public function __construct(){

        parent::__construct('param');
        $this->table_label = 'Params';

        $this->add_columns(
            array(
                (new Column('param_id'))
                    ->set_label('Param ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('name'))
                    ->set_label('Param Name')
                    ->set_name_key()
                    ->set_unike_key(),

                (new Column('description'))
                    ->set_label('Param Description')
                    ->set_type(Column::$COLUMN_TYPE_TEXTAREA)
                    ->set_visible_grid(false),
					
				 (new Column('value'))
                    ->set_label('Param Value')
            )
        );

        $this->init();
    }

}
 