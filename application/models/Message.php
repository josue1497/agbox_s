<?php
class Message extends Model{
 
    public static $YES = 'Y';
    public static $NO = 'N';

    public function __construct()
    {

        parent::__construct('message');
        $this->table_label = 'message';

        $this->add_columns(
            array(
                (new Column('id'))
                    ->set_label('Message ID')
                    ->set_primary_key()
                    ->set_auto_increment()
                    ->set_visible_grid(false)
                    ->set_visible_form(false),

                (new Column('message'))
                    ->set_label('message')
                    ->set_name_key(),

                (new Column('user_to'))
                    ->set_label('user to')
                    ->set_type(Column::$COLUMN_TYPE_SELECT)
                    ->set_fk_entity(new User())
                    ->set_visible_grid(false),

                (new Column('user_from'))
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

                (new Column('message_type'))
                    ->set_label('message type')
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