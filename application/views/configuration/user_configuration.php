<?php
function generate_content($controller,$filename=null,$record=null){

    $html_result=file_get_contents(__DIR__."/user_configuration.html");

    $html_group_icons='<div class="row to">
    <div class="col-6 from my-1" id="origin">
            '.get_user_available_for_user().'
    </div>
</div>';

    // $select_menu=;
    $buttons = ' <div class="row">
                    <div class="col-12 d-flex justify-content-end">
    <button class="btn btn-secondary m-1" id="add-new-icon"><i class="fas fa-plus"></i></button>
    <button class="btn btn-primary m-1" id="save-new-icon"><i class="fas fa-save"></i></button>
    </div></div> ';

    

    $html_result=str_replace('{{ INDEX_ICONS }}',CoreUtils::add_new_card($html_group_icons.$buttons,'Añadir iconos de Acceso rapido'),$html_result);
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

        

        // $('.from')
        //     .children('select')
        //     // call destroy to revert the changes made by Select2
        //     .select2('destroy')
        //     .end()
        //     .append(
        //         // clone the row and insert it in the DOM
        //         $('#content')
        //         .children('select')
        //         .first()
        //         .clone()
        //     );

        $('.to').children('.from').children('select').select2();

    });
});");

    return $html_result;
}

function get_user_available_for_user(){
    $query ="SELECT M.* FROM 
    MENU M INNER JOIN PERMISSION P ON (P.MENU_ID=M.MENU_ID)
            INNER JOIN USER_LEVEL UL ON (UL.ID=P.USER_LEVEL_ID)
            INNER JOIN `USER` U ON (U.USER_LEVEL_ID=UL.ID)
            WHERE U.ID=?";

    $query_admin ="SELECT M.* FROM MENU M ";
    
    $level = Session::get('role_id')==='1';
    $menu_records=Model::get_sql_data($level?$query_admin:$query,array('user_id'=>Session::get('user_id')));

    $html='
    <select name="menus" class="form-control fa"><option value="">Seleccione una Opción</option>';
    foreach($menu_records as $menu){
        $html.=' <option value="'.$menu['menu_id'].'"><span class"'.$menu['icon'].'"></span>'.$menu['title'].'</option>';
    }
    $html.='</select>
';
return $html;


}
