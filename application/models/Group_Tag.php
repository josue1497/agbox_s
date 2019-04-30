<?php 
/**
* 
*/	
class Group_Tag extends Model{
    public function __construct(){
        parent::__construct('group_tag');
        $this->table_label = 'Tags In Groups';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Id')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                 (new Column('group_id'))
					->set_label('Group')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Group())
					->set_name_key(),

				 (new Column('tag_id'))
					->set_label('Tag')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Tag())
					->set_name_key()
             )
        );
        $this->init();
    }
	
	public static function update_group_tags($new_tags,$group_id){
		$model = new Group_Tag();
		/* borrar las relacions previas antes de hacer nuevas relaciones */
		Model::execute_update("delete from ". $model->table_name. " where group_id = ".$group_id);
		//$model->delete($group_id);
		/* crear nuevas relaciones */
		foreach($new_tags as $new_tag_id){
			$model->create(array('group_id'=>$group_id,'tag_id'=>$new_tag_id));
		}
	}
}
?>