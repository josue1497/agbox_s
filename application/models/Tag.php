<?php
class Tag extends Model
{

    public function __construct(){
        parent::__construct('tag');
        $this->table_label = 'Tags';

        $this->add_columns(
            array(
                (new Column('tag_id'))
                    ->set_label('Tag ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('label'))
                    ->set_label('Tag Label')
                    ->set_name_key()
                    ->set_unike_key()
            )
        );

        $this->init();
    }
	
	/**
	* metod para validar que todas las etiquetas ingresadas sean ids de base de datos, 
	* sino, insertarlas
	*/
	public static function validate_tags($tags_array){
		$ret_value=array();
		$model = new Tag();
		foreach($tags_array as $tag){
			if(!is_numeric($tag)){
				$properties = array('label'=>$tag);
				$model->create($properties);
				$row = $model->get_by_property($properties);
				$ret_value[]=$row['tag_id'];
			}else{
				$ret_value[]=$tag;
			}
		}
		return $ret_value;
	}

}
 