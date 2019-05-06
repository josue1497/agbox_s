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
        return Model::get_sql_data('SELECT
        M.*,
        IIT.FIRST_MENU_ID,
        IIT.FIFTH_MENU_ID,
        IIT.FOURTH_MENU_ID,
        IIT.SECOND_MENU_ID,
        IIT.SIXTH_MENU_ID,
        IIT.THIRD_MENU_ID
    FROM
        MENU M
    INNER JOIN ITEM_INDEX_PAGE IIT ON
        (M.MENU_ID IN (IIT.FIRST_MENU_ID,
        IIT.FIFTH_MENU_ID,
        IIT.FOURTH_MENU_ID,
        IIT.SECOND_MENU_ID,
        IIT.SIXTH_MENU_ID,
        IIT.THIRD_MENU_ID))
    WHERE
        IIT.USER_ID = ?',array('user_id'=>$user_id));
    }

}
