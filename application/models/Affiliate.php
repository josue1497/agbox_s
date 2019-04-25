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

                (new Column('approved'))
                    ->set_label('Aprobado')
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
} 