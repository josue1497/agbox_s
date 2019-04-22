<?php
class Notification extends Model{

    public static $AFFILIATE = 'affiliate';
    public static $APPROVE_AFFILIATE = 'approve_affiliate';
    public static $DECLINE_AFFILIATE = 'decline_affiliate';
    public static $DESAFFILIATE_USER = 'desaffiliate_user';
    public static $CHANGE_ROLE = 'change_role';
    public static $REQUEST_MEMBERSHIP = 'request_membership';
    public static $NEW_MEMBER = 'new_member';

 
    public static $YES = 'Y';
    public static $NO = 'N';

    public function __construct()
    {

        parent::__construct('notification');
        $this->table_label = 'notification';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Notification ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),
                (new Column('message'))
                    ->set_label('message')
                    ->set_name_key(),
                (new Column('user_to_id'))
                    ->set_label('user to')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity(new User())
                    ->set_visible_grid(false),
                (new Column('controller_to'))
                    ->set_label('controller_to')
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_visible_grid(false),
                (new Column('entity_id'))
                    ->set_label('entity_id')
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_visible_grid(false),
                (new Column('notification_type'))
                    ->set_label('notification_type')
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_visible_grid(false),
                (new Column('shipping_date'))
                    ->set_label('shipping_date')
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_visible_grid(false),
                (new Column('read'))
                    ->set_label('read')
                    ->set_type(Column::$COLUMN_TYPE_TEXT)
                    ->set_visible_grid(false)                
            )
        );

        $this->init();
    }

    /**
     * Metodo para crear notificaciones cada vez que se necesite
     * params $params array con caracteristicas de la notificaciones
     *  ejemplo
     * array('user_to_id'=>$affiliate_record['user_id'],
                'message'=>'Solicitud Aprobada',
                'entity_id'=>$affiliate_record['group_id'],
                'notification_type'=>Notification::$APPROVE_AFFILIATE,
                'controller_to'=>'groups/group_information',
                'read'=>Notification::$NO)
     */
    public static function create_notification(array $params){
        $notification= new Notification();

        return $notification->create($params);

    }
}