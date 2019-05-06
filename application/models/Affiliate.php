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
                    ->set_label('Grupo')
                    ->set_name_key()
                    ->set_unike_key(true)
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity(new Group()),

                (new Column('user_id'))
                    ->set_label('Usuario')
                    ->set_name_key()
                    ->set_unike_key(true)
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity(new User()),

				(new Column('role_id'))
					->set_label('Rol')
					->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_fk_entity(new Role())
					->set_name_key(),

                (new Column('approved'))
                    ->set_label('Aprobado')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
					->set_values(array('Yes','No'))
            )
        );

        $this->init();
    }

    public static function delete_affiliation($id){
        $affiliate = new Affiliate();
        return $affiliate->delete($id);
    }

    public static function count_affilate_groups($user_id){

        $result=Model::get_sql_data("select count(*) as result from affiliate where user_id=? and approved='Yes'", array('user_id'=>$user_id));

        return $result[0]['result'];

    }

    public static function create_new_affiliate(array $params,$auto_approve=false){
        if(isset($params['user_id'])&& isset($params['group_id'])){
            if($auto_approve){
                $params['approved']='Yes';
            }

            $affiliate_model = new Affiliate();

            $group_record= (new Group)->findByPoperty(array('id'=>$params['group_id']));

            $req1 = $affiliate_model->create($params);

            if($req1){
                $affiliate_record= $affiliate_model->findByPoperty(array('user_id'=>$params['user_id'],
                                                                    'group_id'=>$params['group_id']));
                if(!$auto_approve){
                Notification::create_notification(array('user_to_id'=>$params['user_id'],
                'message'=>'A sido invitado a participar en el grupo "'.$group_record['name'].'"',
                'entity_id'=>$affiliate_record['id'],
                'notification_type'=>Notification::$REQUEST_MEMBERSHIP,
                'controller_to'=>'affiliate/approve_request',
                'read'=>Notification::$NO));

                return true;
                    }
        }else{
            return false;
        }
        }
        return true;
    }

    /* agregados de group_user_role */

    public static function get_user_by_role($role_name,$group_id){
		$gur = new Affiliate();
		$role_model = new Role();
        $user_model = new User();
        
        $role_record=Role::get_role_id($role_name);
        
		$gur_record=$gur->findByPoperty(array('role_id'=>$role_record, 'group_id'=>$group_id));
                
        $user_to=$user_model->findByPoperty(array('id'=>$gur_record['user_id']));

        return $user_to;
    }

    public static function set_user_role($group_id,$user_id,$role_id){
        $model = new Affiliate();
        $role_model = new Role();
        
        /* valida que el si el grupo tiene lider se modifique el registro para establecer este user_id 
        y si el usuario tiene otro rol se eliminas	*/
        $lider_role=$role_model->get_by_property(array('value'=>'L'));
        
        if($lider_role['id'] == $role_id){
        
            /*verifica si el usuario ya existe con otro rol y de ser asi borra el registro*/
            $params = array('group_id'=>$group_id,'user_id'=>$user_id);
            $record = $model->get_by_property($params);
        
            if($record != null && $record['role_id']!=$role_id){
                $model->delete($record['id']);
            }
        
        /* finalmente establecerlo como el lider */
        return Affiliate::set_group_lider($group_id,$user_id);
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
        
        $m = new Affiliate(); 
        
        /* armar los parametros de la consulta de rol de usuario grupo para ver si ese grupo ya tiene lider */
        $params = array('group_id'=>$group_id,'role_id'=>$lider_role_id);
        $record = $m->get_by_property($params);
        
        
        $status = false;
        if($record!=null){
        /* si ya tiene lider, se cambia el user_id al registro del lider del grupo*/
            $record['user_id']=$user_id;
            return $m->edit($record['id'],$record);
        }else{
        /* si no existe el registro se crea */
            $params['user_id']=$user_id;
            return $m->create($params);
        }
    }

    public static function delete_group_user_role($user_id, $group_id,$role_id){
        $gur = new Affiliate();

        $record=$gur->findByPoperty(array('user_id'=>$user_id,'group_id'=>$group_id,'role_id'=>$role_id));
        
        return $gur->delete($record['id']);

    }

    public static function is_leader($group_id,$user_id){
         $gur =(new Group())->findByPoperty(array('id'=>$group_id));

         return $gur['leader_id']=== $user_id;
    }

} 