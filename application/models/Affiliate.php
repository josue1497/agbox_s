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
                    ->set_name_key()
                    ->set_unike_key(true)
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity(new Group()),

                (new Column('user_id'))
                    ->set_label('User')
                    ->set_name_key()
                    ->set_unike_key(true)
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity(new User()),

                (new Column('approved'))
                    ->set_label('Approved')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No')),
            )
        );

        $this->init();
    }

    public static function delete_affiliation($id){
        $affiliate = new Affiliate();
        return $affiliate->delete($id);
    }

    public static function count_affilate_groups($user_id){

        $result=Model::get_sql_data("select count(*) as result from affiliate where user_id=?", array('user_id'=>$user_id));

        return $result[0]['result'];

    }

}
 