<?php 
/**
* 
*/	
class Group_User_Role extends Model{
    public function __construct(){
        parent::__construct('group_user_role');
        $this->table_label = 'User Role In Group';

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

				 (new Column('user_id'))
					->set_label('User')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new User())
					->set_name_key(),

				(new Column('role_id'))
					->set_label('Role')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Role())
					->set_name_key(),
				
             )
        );
        $this->init();
    }

    public static function get_user_by_role($role_name,$group_id){
		$gur = new Group_User_Role();
		$role_model = new Role();
        $user_model = new User();
        
        $role_record=$role_model->findByPoperty(array('name'=>$role_name));
        
		$gur_record=$gur->findByPoperty(array('role_id'=>$role_record['id'], 'group_id'=>$group_id));
                
        $user_to=$user_model->findByPoperty(array('id'=>$gur_record['user_id']));

        return $user_to;
    }

    public static function set_user_role($group_id,$user_id,$role_id){
        $model = new Group_User_Role();
        
        /* valida que el si el grupo tiene lider se modifique el registro para establecer este user_id 
        y si el usuario tiene otro rol se eliminas	*/
        $lider_role=$model->get_by_property(array('name'=>'Lider'));
        
        if($lider_role['id'] == $role_id){
        
            /*verifica si el usuario ya existe con otro rol y de ser asi borra el registro*/
            $params = array('group_id'=>$group_id,'user_id'=>$user_id);
            $record = $model->get_by_property($params);
        
            if($record != null && $record['role_id']!=$role_id){
                $model->delete($record['id']);
            }
        
        /* finalmente establecerlo como el lider */
        return Group_User_Role::set_group_lider($group_id,$user_id);
        /* TODO verificar si el viejo lider se cambia a participante u otro rol */
        
        }
        
        /* verifica si ya existe este usuario en el grupo */
        $params = array('group_id'=>$group_id,'user_id'=>$user_id);
        $record = $model->get_by_property($params);
        $status=false;
        /* de no ser asi le crea el rol */
        if($record == null || empty($record)){
            $params['role_id']=$role_id;
            $status = $model->create($params);
        }else{
        /* de ser asi le actualiza el rol*/
            $record['role_id']=$role_id;
            $status = $model->edit($record['id'],$record);
        }
        return $status;
        }
        
        public static function set_group_lider($group_id,$user_id){
        /* obtener el id del rol lider*/
        $model = new Role();
        $lider_role=$model->get_by_property(array('name'=>'Lider'));
        $lider_role_id = ($lider_role != null ? $lider_role['id'] : 1 );
        
        $m = new Group_User_Role(); 
        
        /* armar los parametros de la consulta de rol de usuario grupo para ver si ese grupo ya tiene lider */
        $params = array('group_id'=>$group_id,'role_id'=>$lider_role_id);
        $record = $m->get_by_property($params);
        
        
        $status = false;
        if($record!=null){
        /* si ya tiene lider, se cambia el user_id al registro del lider del grupo*/
            $record['user_id']=$user_id;
            $status = $m->edit($record['id'],$record);
        echo 'Actualizado: '.$status;
        }else{
        /* si no existe el registro se crea */
            $params['user_id']=$user_id;
            $status = $m->create($params);
        }
    }

    public static function delete_group_user_role($user_id, $group_id,$role_id){
        $gur = new Group_User_Role();

        $record=$gur->findByPoperty(array('user_id'=>$user_id,'group_id'=>$group_id,'role_id'=>$role_id));
        
        return $gur->delete($record['id']);

    }

    
        
}
?>