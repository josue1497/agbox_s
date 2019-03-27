<?php
function generate_content($controller, $filename = null, $record = null)
{
    return CoreUtils::put_in_card(
        '<div class="container">
			<div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="query_area">SQL CODE</label>
                        <textarea class="form-control" id="query_area" name="query_area" rows="5"></textarea>
                    </div>
              </div>
            </div> 
            <div class="row">
                <div class="col-md-10 col-sm-6">
                    <div class="p-4" id="alert_result">
                        <span id="query_result">Waiting ...</span>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="p-4">
                        <button class="btn btn-primary" id="btn_execute">Execute</button>
                    </div>
                </div>
            </div>
		</div>',
        'SQL Console'
    );
}
 