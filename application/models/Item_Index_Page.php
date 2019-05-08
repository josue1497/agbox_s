<?php
class Item_Index_Page extends Model{
	 public function __construct(){
        parent::__construct('item_index_page');
        $this->table_label = 'Iconos visuales en la Pantalla de Inicio';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Id')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                 (new Column('menu_id'))
					->set_label('Acceso #1')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Menu())
                    ->set_name_key(),
                    
				 (new Column('user_id'))
					->set_label('User')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User())
					->set_name_key()
				
             )
        );
        $this->init();
    }

    public static function get_icons($user_id){
        return Model::get_sql_data('select
        m.*,
        iit.first_menu_id,
        iit.fifth_menu_id,
        iit.fourth_menu_id,
        iit.second_menu_id,
        iit.sixth_menu_id,
        iit.third_menu_id
    from
        menu m
    inner join item_index_page iit on
        (m.menu_id in (iit.first_menu_id,
        iit.fifth_menu_id,
        iit.fourth_menu_id,
        iit.second_menu_id,
        iit.sixth_menu_id,
        iit.third_menu_id))
    where
        iit.user_id = ?',array('user_id'=>$user_id));
    }

    public static function create_new_icon($menu_id,$user_id){
        $model = new Item_Index_Page();

        return Model::save_record($model, array('menu_id'=>$menu_id,'user_id'=>$user_id));

    }

}
