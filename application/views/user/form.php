<script>
$(function() {
  $("#nombre_usuario").on("keyup", function(event) {
    var value = $(this).val();
    if (value.indexOf(' ') != -1) {
      $(this).val(value.replace(/ /g, ""));
    }
  })
});

	function check_pass(){
		if(document.getElementById('clave_usuario').value == ''){
			alert('La clave no puede estar vacia!');
			return false;
		}
		if(document.getElementById('clave_usuario').value != document.getElementById('re_clave_usuario').value){
			alert('Las claves no coinciden!');
			document.getElementById('re_clave_usuario').value='';
			return false;
		}
		return true;
	}
</script>
<form method='post' action='#' onsubmit = 'return check_pass()'>
		{{ auto_build_form_content }}
</form>