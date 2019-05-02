<?php
function generate_content($controller, $filename = null, $record = null)
{
    $record = $controller->vars;
    $this_record = $record['record'];
    
    $html_result = file_get_contents(__DIR__ . '/list_group.html');

    $table=generate_table($controller,$this_record);
    $table=str_replace('edit','group_information',$table);

    $table=str_replace('btn btn-secondary','d-none',$table);

    $title='<div class="d-flex align-items-center">Tus Grupos
            <div class=" ml-auto">
            <a class="btn btn-primary" href="'.SERVER_DIR.'groups/create_group" '.Component::set_tooltip_info("Crea un Grupo").'><i class="fas fa-plus"></i></a>
            <a class="btn btn-primary" href="'.SERVER_DIR.'affiliate/items" '.Component::set_tooltip_info("Afiliate a un Grupo").'><i class="fas fa-user-plus"></i></a>
            </div>
        </div>';

    $html_result = str_replace('{{ GROUP_LIST }}', CoreUtils::add_new_card($table,$title), $html_result);

    $controller->view->add_script_js(' $(\'#notif\').DataTable( {
        "scrollY":        "50vh",
        "scrollCollapse": true,
        "processing": true,
        "serverSide": false,
        "deferLoading": 57,
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

function generate_table($controller,$record){

    // auto_build_list_content
    // $record= Model::get_sql_data('SELECT * FROM notification WHERE user_to_id='.Session::get('user_id').' ORDER BY shipping_date DESC');
    $notifi_table=' <div class="row container">
    <div class="col-12">
            <table id="notif" class="table table-striped table-hover w-100 display responsive">'
            .$controller->view->auto_build_list_content($record).'
                  </table>
    </div>
    </div>';
    return $notifi_table;
}
