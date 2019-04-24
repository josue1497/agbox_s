<?php
function generate_content($controller, $filename = null, $record = null)
{
    $html_result = file_get_contents(__DIR__ . '/list.html');

    $html_result = str_replace('{{ NOTIFICATION_LIST }}', CoreUtils::add_new_card('HOLAMUNDO', 'Notificacion'), $html_result);

    return $html_result;
}

function generate_table(){
    $record= Model::get_sql_data('SELECT * from notification n where n.user_to_id=? order by n.shipping_date desc',
         array('user_id'=>Session::get('user_id')));

    $notifi_table='';
}
