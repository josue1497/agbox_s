<?php
function generate_content($controller, $filename = null, $record = null)
{
    $html = array
  (
    array('content'=>'<div class="container">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="query_area">SQL CODE</label>
                <textarea class="form-control" id="query_area" name="query_area" rows="5"></textarea>
            </div>
      </div>
    </div> 
    <div class="row">
        <div class="col-8">
            <div class="p-4" id="alert_result">
                <span id="query_result">Waiting ...</span>
            </div>
        </div>
        <div class="col-2">
            <div class="p-4">
                <button class="btn btn-primary" id="btn_execute">Execute</button>
            </div>
        </div>
    </div>
</div>','title'=>"SQL Console",'dimension'=>"7"),
    array('content'=>'<div class="container">
    <div class="row">
        <div class="col">
            <div class="form-group">
            <div id="result_sql">
                <h5>RESULT</h5>
            </div>
                <pre id="json"></pre>
            </div>
      </div>
    </div> 
</div>','title'=>"Result",'dimension'=>"5"),
  );


  $result=CoreUtils::add_row_card($html);

    return $result;
}


 