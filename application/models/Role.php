<?php
class Role extends Model{
	public function __construct(){
		
		parent::__construct('role');
		$this->table_label='Role';
		
		$this->add_columns(
			array(
				(new Column('id'))
				->set_label('ID')
				->set_primary_key()
				->set_auto_increment()
				->set_visible_grid(false)
				->set_visible_form(false),
				
				(new Column('name'))
				->set_label('Role Name')
				->set_name_key()
				->set_unike_key(),
				
				(new Column('description'))
				->set_label('Description')
				->set_type(Column::$COLUMN_TYPE_TEXTAREA)
				->set_visible_grid(false),

				(new Column('value'))
				->set_label('Value')
				->set_type(Column::$COLUMN_TYPE_TEXT)
				->set_visible_grid(false)
			)
		);
		$this->init();
	}

	public static function get_role_name($id){
		$role = new Role();
		$record=$role->findByPoperty(array('id'=>$id));
		return $record['name'];
	}

	public static function get_role_id_by_name($role_name){
        $role = new Role();

        $record=$role->findByPoperty(array('name'=>$role_name));
        
        return $record['id'];

	}
	
	public static function get_role_id($status){
		$record=(new Role)->findByPoperty(array('value'=>$status));
		return $record['id'];
	}

	public static function get_leader_id(){
		return get_role_id('L');
	}

	public static function get_admin_id(){
		return get_role_id('A');
	}

	public static function get_member_id(){
		return get_role_id('M');
	}
}
?>