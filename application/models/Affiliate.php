<?php
class Affiliate extends Model
{

    public function __construct()
    {

        parent::__construct('affiliate');
        $this->table_label = 'User affiliates in a Group';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Record ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('group_id'))
                    ->set_label('Group')
                    ->set_fk_entity(new Group()),

                (new Column('user_id'))
                    ->set_label('User')
                    ->set_fk_entity(new Usuario())
                    )
        );

        $this->init();
    }

}
 