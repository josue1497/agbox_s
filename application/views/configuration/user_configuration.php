<?php
function generate_content($controller,$filename=null,$record=null){

    $html_result=file_get_contents(__DIR__."/user_configuration.html");

    $html_group_icons='<div class="row to m-2">
            '.get_icons(Session::get('user_id')).'
</div>';

    // $select_menu=;
    $buttons = ' <div class="row">
                    <div class="col-12 d-flex justify-content-end">
    <button class="btn btn-secondary m-1" id="add-new-icon"><i class="fas fa-plus"></i></button>
    <button class="btn btn-primary m-1" id="save-new-icon"><i class="fas fa-save"></i></button>
    </div></div> ';

    $title='<div class="d-flex align-items-center">Iconos de acceso rápido
    <button class="btn btn-info ml-auto" data-toggle="popover" title="Ayuda" 
            data-content="En este apartado usted podra seleccionar<br>que opciones estaran disponibles 
            directamente<br>en la página principal de la aplicación" data-trigger="focus" data-html="true">
        <i class="fas fa-question text-white"></i>
    </button>
    </div>';

    

    $html_result=str_replace('{{ INDEX_ICONS }}',CoreUtils::add_new_card($html_group_icons.$buttons,$title),$html_result);
    // $html_result=str_replace('{{ ADD_ICON }}',$buttons,$html_result);

    $controller->view->add_script_js("
    $(document).ready(function () {
        $('.from').children('select').select2();
    $('#add-new-icon').click(function(){
        
        $('.from')
            .children('select')
            .select2('destroy')
            .end();
            
        $( '#origin' ).clone(true,true).appendTo( '.to' );

        $('.to').children('.from').children('select').select2();

    });

    $('#save-new-icon').click(function(){
        var icons = new Array();

        $('select.fa').each(function(){
            icons.push($(this).val());
        });

      

        $.post( '".SERVER_DIR."configuration/save_index_icons',
      {'info':icons,'user_id':'".Session::get('user_id')."'}, function( data ) {
               console.log(data);
               if(''!==data && 'fail'!==data){
                maketoast('success', 'Exitoso!', 'Se ha Guardado su configuración'); 
                location.href='".SERVER_DIR."index/index';

               }else{
                maketoast('danger', 'Error!', 'No se ha Guardado la Configuración'); 
               }
             });
    });  
});");

    return $html_result;
}

function get_user_available_for_user($menu_id=null){
    $query ="select m.* from 
    menu m inner join permission p on (p.menu_id=m.menu_id)
            inner join user_level ul on (ul.id=p.user_level_id)
            inner join `user` u on (u.user_level_id=ul.id)
            where u.id=? and m.url not in ('','#')";

    $query_admin ="select m.* from menu m ";
    
    $level = Session::get('role_id')==='1';
    $menu_records=Model::get_sql_data($level?$query_admin:$query,array('user_id'=>Session::get('user_id')));

    $html='<div class="col-6 from my-1" id="origin">
    <select name="menus" class="form-control fa"><option value="">Seleccione una Opción</option>';
    foreach($menu_records as $menu){
        $html.=' <option value="'.$menu['menu_id'].'" '.($menu_id!=null && $menu['menu_id']===$menu_id? ' selected ':'').'><span class"'.$menu['icon'].'"></span>'.$menu['title'].'</option>';
    }
    $html.='</select></div>
';
return $html;

}

function get_icons($user_id){
    $query = 'select m.* from menu m inner join item_index_page ip on (ip.menu_id=m.menu_id)
    where ip.user_id=?';

    $icons = Model::get_sql_data($query, array('user_id' => $user_id));

    $html='';

    if(!empty($icons)){
        foreach($icons as $icon){
            $html.=get_user_available_for_user($icon['menu_id']);
        }
    }else{
        $html.=get_user_available_for_user();
    }

    return $html;
}

function build_select($icons){

}
