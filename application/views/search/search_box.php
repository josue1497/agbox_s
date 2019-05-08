<?php
function generate_content($controller, $filename = null, $record = null){
    $html_result = file_get_contents(__DIR__ . '/list.html');
    $html_result = str_replace('{{ RESULTS_LIST }}', CoreUtils::add_new_card(generate_table($record), 'Resultados'), $html_result);

    $controller->view->add_script_js(' $(\'#notif\').DataTable( {
        "scrollY":        "50vh",
        "scrollCollapse": true,
        "ordering": false,
        "searching": false,
        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]]
    } );');

    return $html_result;
}

function generate_table($post = null){
	$q = $post['q'];

$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",",",".",";");
$caracteres_buenos = array(" ");

$words = explode(' ', str_replace($caracteres_malos, $caracteres_buenos, $q));

	$groups_sql = 
		"SELECT 
			g.name AS group_name, 
			g.description as group_description, 
			ifnull(GROUP_CONCAT( t.label ),'') labels, 
			(SELECT COUNT(1) FROM affiliate a WHERE a.group_id = 
				g.id AND a.approved = 'Yes') members, 
			(CASE WHEN u.id IS NOT NULL THEN 
				CONCAT( u.names,  ', ', u.lastnames ) ELSE  '' END ) AS group_leader,
			'Group' as result_type,
			concat(concat(ifnull(g.name,''),' ',ifnull(g.description,''),' ',
			ifnull(GROUP_CONCAT( t.label ),'')),' ',
			concat((CASE WHEN u.id IS NOT NULL THEN 
				CONCAT( u.names,  ', ', u.lastnames ) ELSE  '' END ),' ','Group'))as search_summary
		FROM groups g 
		left JOIN group_tag gt ON gt.group_id = g.id
		left JOIN tag t ON t.tag_id = gt.tag_id
		LEFT JOIN user u ON u.id = g.leader_id ";
		
		$sql_where = "Where ";
		$k = 0;
		foreach($words as $word){
			$sql_where .= (($k>0?" OR ":"")." upper(search_summary)
				like upper('%$word%') ");
				$k++;
		}

		$sql_group_by = "GROUP BY g.name";
		
		$sql = "select * from (".
    		$groups_sql.$sql_group_by
    		.")t1 ".$sql_where;

    $record= Model::get_sql_data($sql);

    $notifi_table=' <div class="row container">
    <div class="col-12">
            <table id="notif" class="table table-striped table-hover w-100 display responsive">
                    <thead class="bg-primary text-white text-center">
                        <th scope="col">Listado de Resultados</th>
                    </thead>
                    <tbody>';
        foreach($record as $notification){

            $text=$notification['read']==="N"?"text-dark font-weight-bold ":"text-muted font-weight-normal";
			$uri_to=SERVER_DIR.$notification['controller_to'].'/'.$notification['entity_id'];
			$to_read = SERVER_DIR.'notification/read_notification';
            $notifi_table.=  '<tr>
            <td>
                <a  >'.
                /*onclick="toReadNotification(\''.$uri_to.'\',\''.$to_read.'\',\''.$notification['id'].'\')" */
                    '<span class="'.$text.'">'.
                    	((isset($notification['group_name'])&& 
                    		 !empty($notification['group_name']))?
                    		($notification['group_name']):'').

                    	((isset($notification['group_description'])&& 
                    		 !empty($notification['group_description']))?
                    		(' - '.$notification['group_description']):'').
						
						((isset($notification['members'])&&
                    		!empty($notification['members']))?
                    		(' Integrantes: '.$notification['members']):'').

                    	((isset($notification['group_leader'])&&
                    		!empty($notification['group_leader']))?
                    		(' Lider: '.$notification['group_leader']):'').
                    '</span>
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
?>