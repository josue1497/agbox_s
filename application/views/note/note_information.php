<?php
function generate_content($controller, $filename = null, $record = null)
{
    return CoreUtils::put_in_card(
        '<div class="container">
			Hola Mundo!
		</div>',
        'Test'
    );
}
 