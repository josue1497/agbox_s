<?php
class Group extends Model
{

    public function __construct()
    {

        parent::__construct('groups');
        $this->table_label = 'Groups';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Group ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),
                     
                (new Column('group_photo'))
                    ->set_label('Imagen de grupo')
                    ->set_type(Column::$COLUMN_TYPE_PHOTO)
                    ->set_file_type("image/png, .jpeg, .jpg, image/gif")
                    ->set_visible_grid(false),

                (new Column('name'))
                    ->set_label('Nombre de grupo')
                    ->set_name_key()
                    ->set_unike_key()
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_field_html('is_required="true" ') ,

                (new Column('description'))
                    ->set_label('Propósito del grupo')
                    ->set_type(Column::$COLUMN_TYPE_TEXTAREA)
                    ->set_visible_grid(false)
                    ->set_field_html('is_required="true" ') ,
      
                (new Column('parent_group_id'))
                    ->set_label('Parent Group')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity($this)
                    ->set_visible_grid(false)
                    ->set_visible_form(false),
					
                (new Column('leader_id'))
                    ->set_label('Lider del grupo')
                    ->set_visible_grid(false)
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_field_html('is_required="true" ') 
                    ->set_values((new User())->get_select_data()),

					
                (new Column('tags'))
                    ->set_label('Etiquetas')
                    ->set_visible_grid(false)
					->set_column_in_db(false)
                    ->set_type(Column::$COLUMN_TYPE_SELECT_MULTIPLE)
                    ->set_values((new Tag())->get_select_data())
            )
        );

        $this->init();
    }

    public static function get_group_name($id){
        $group = new Group();
        $record=$group->findByPoperty(array('id'=>$id));
        return $record['name'];
    }
	
	/**
	* metodso para validar las etiquetas seleccionadas
	*/
	public function validate_tags($data,$group_id){
		if(isset($data) && isset($data['tags'])){
			/* se valida que las etiquetas seleccionadas existan en db, sino, se insertan*/
			$data['tags'] = Tag::validate_tags($data['tags']);
			/* se inserta o actualza la relacion entre la etiqueta y el grupo */
			Group_Tag::update_group_tags($data['tags'],$group_id);
		}
	}
	/**
	* logica para antes de salvar
	*/
	public function before_save($data,$id=null){}
	/**
	* logica para despues de salvar
	*/
	public function after_save($data,$id){
		$this->validate_tags($data,$id);
		return $data;
	}
	/**
	* logica para antes de eliminar
	*/
	public function before_delete($id){}
	/**
	* logica para despues de eliminar
	*/
	public function after_delete($id){}
	/**
	* logica para antes de mostrar form
	*/
	public function before_render_form($record,$id=null){
		if(isset($id)){
			$model = new Group_Tag();
			$rows = $model->get_by_property(array('group_id'=>$id),true);
			foreach($rows as $row){
				$record['tags'][] = $row['tag_id'];
			}
		}
		return $record;
	}
	/**
	*logica para antes de mostrar lista
	*/
	public function before_render_list($records){}
}
 