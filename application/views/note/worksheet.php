<?php
function generate_content($controller, $filename = null, $record = null){
    $controller->view->add_script_js('$("#makeEditable").SetEditable({
          $addButton: $("#but_add"),
          columnsEd: null,  // Ex.: "1,2,3,4,5"
          onEdit: function() { console.log(this);},
          onDelete: function() {console.log("delete");},
          onBeforeDelete: function() {console.log("antes de delete");},
          onAdd: function() {console.log("add");}
            
        });');
    return file_get_contents(__DIR__.'/worksheet.html');
}