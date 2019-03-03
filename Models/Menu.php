<?php
class Menu extends Model{
	
	public function __construct(){
		
		parent::__construct('menu');
		$this->table_label='Menu';
		
		$this->add_columns(
			array(
				(new Column('id_menu'))
				->set_label('Id del Menu')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('titulo_menu'))
				->set_label('Titulo del Menu')
				->set_name_key()
				->set_unike_key(),
				
				(new Column('descripcion_menu'))
				->set_label('Descripcion del Menu')
				->set_type(Column::$COLUMN_TYPE_TEXTAREA)
				->set_visible_grid(false),
				
				(new Column('id_menu_padre'))
				->set_label('Menu Padre')
				->set_type(Column::$COLUMN_TYPE_SELECT)
				->set_fk_entity($this)
				->set_visible_grid(false),
				
				(new Column('icon_menu'))
				->set_label('Icono del Menu')
				->set_type(Column::$COLUMN_TYPE_ICONPICKER),
				
				(new Column('orden_menu'))
				->set_label('Orden de Menu')
				->set_type(Column::$COLUMN_TYPE_NUMBER)
				->set_visible_grid(false),
				
				(new Column('url_menu'))
				->set_label('Url del Menu')
				->set_field_help('modelo/vista')
				
				
			)
		);
		
		$this->init();
	}
	
	public function get_menu_data(){
		$menu_array=array();
		$menu_parents=array();
		$menu_childs=array();
		
		$menu_list = $this->sort_by_key($this->get_array_data(),'order_menu');
		
		foreach($menu_list as $row){
			if(isset($row['id_menu_padre']) && $row['id_menu_padre']>0){
				$menu_childs[] = $row;
			}else{
				$menu_parents[] = $row;
			}
		}
		
		foreach($menu_parents as $parent){
			foreach($menu_childs as $child)
				if($child['id_menu_padre']==$parent['id_menu'])
					$parent['childs'][]=$child;
			$menu_array[]=$parent;
		}
		
		return $menu_array;
	}

	public function sort_by_key($arr,$key){
		$len = count($arr);
		for($i=0;$i<$len-1;$i++){
			if($arr[$i][$key]>$arr[$i+1][$key]){
				$aux = $arr[$i];
				$arr[$i] = $arr[$i+1];
				$arr[$i+1] = $aux;
			}
		}
		return $arr; 
	}
}
?>