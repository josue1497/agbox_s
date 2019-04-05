<?php
class Notification extends Model{

    public static $AFFILIATE = 'affiliate';
    public static $APPROVE_AFFILIATE = 'approve_affiliate';
    public static $DECLINE_AFFILIATE = 'decline_affiliate';


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

    public static function create_notification(array $params){
        $notification= new Notification();

        return $notification->create($params);

    }
}