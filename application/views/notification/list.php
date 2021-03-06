<?php
function generate_content($controller, $filename = null, $record = null)
{
    $html_result = file_get_contents(__DIR__ . '/list.html');

    $html_result = str_replace('{{ NOTIFICATION_LIST }}', CoreUtils::add_new_card(generate_table(), 'Notificacion'), $html_result);

    $controller->view->add_script_js(' $(\'#notif\').DataTable( {
        "scrollY":        "50vh",
        "scrollCollapse": true,
        "ordering": false,
        "searching": false,
        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        "language": {
			"lengthMenu": "Mostrar _MENU_ lineas",
			"zeroRecords": "Lo siento, no hay datos para mostrar",
			"info": "Pagina _PAGE_ de _PAGES_",
			"infoEmpty": "Registros no encontrados",
			"infoFiltered": "(Filtrados desde _MAX_ registros totales)",
			"search": "<i class=\"fas fa-search\"></i>",
			"paginate": {
				"first": "Primero",
				"last": "Último",
				"next": "<i class=\"fas fa-angle-double-right\"></i>",
				"previous": "<i class=\"fas fa-angle-double-left\"></i>"
            }
        }
    } );');

    return $html_result;
}

function generate_table(){
    $record= Model::get_sql_data('SELECT * FROM notification WHERE user_to_id='.Session::get('user_id').' ORDER BY shipping_date DESC');
    $notifi_table=' <div class="row container">
    <div class="col-12">
            <table id="notif" class="table table-striped table-hover w-100 display responsive">
                    <thead class="bg-primary text-white text-center">
                        <th scope="col">Listado de Notificaciones</th>
                    </thead>
                    <tbody>';
        foreach($record as $notification){

            $text=$notification['read']==="N"?"text-dark font-weight-bold ":"text-muted font-weight-normal";
			$uri_to=SERVER_DIR.$notification['controller_to'].'/'.$notification['entity_id'];
			$to_read = SERVER_DIR.'notification/read_notification';
            $notifi_table.=  '<tr>
            <td>
                <a  onclick="toReadNotification(\''.$uri_to.'\',\''.$to_read.'\',\''.$notification['id'].'\')" >
                    <span class="'.$text.'">'.$notification['message'].'</span>
                </a>
            </td>
          </tr>';
        }
                      
        $notifi_table.=  '</tbody>
                  </table>
    </div>
    </div>';
    return $notifi_table;
}
