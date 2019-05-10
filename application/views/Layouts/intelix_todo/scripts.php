<!-- Bootstrap core JavaScript- - >
<script src="{{ base_url }}application/views/Layouts/vendor/jquery/jquery.min.js"></script>
<!--
<script src="{{ base_url }}application/views/Layouts/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
-->

<!-- jQuery CDN - - >
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Bootstrap CDN - - >
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<!-- END CDN -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> -->

<script src="{{ base_url }}application/views/Layouts/scripts/popper.min.js"></script>

<script src="{{ base_url }}application/views/Layouts/scripts/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ base_url }}application/views/Layouts/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ base_url }}application/views/Layouts/scripts/sb-admin-2.min.js"></script>

<!-- Bootstrap-Iconpicker Bundle -->
<script src="{{ base_url }}application/views/Layouts/vendor/icon-picker/js/bootstrap-iconpicker.bundle.min.js"></script>

<script src="{{ base_url }}application/views/Layouts/scripts/jquery.toaster.js"></script>

<script src="{{ base_url }}application/views/Layouts/scripts/functions.js"></script>

<script src="{{ base_url }}application/views/Layouts/DataTables/datatables.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script> -->

<script src="{{ base_url }}application/views/Layouts/scripts/select2.full.js"></script>

<script src="{{ base_url }}application/views/Layouts/scripts/vue.js"></script>

<script src="{{ base_url }}application/views/Layouts/scripts/axios.js"></script>

<script type="text/javascript" src="{{ base_url }}application/views/Layouts/slick/slick.min.js"></script>


<script>
	$('.select2').select2({
		placeholder: 'Select an option',
		width: '100%',
	});
	$('.select2_multiple').select2({
		placeholder: 'Select an option',
		width: '100%',
		tags: true
	});
</script>

<script>
	$('.data-table').DataTable({
		"lengthMenu": [
			[5, 10, 25, 50, -1],
			[5, 10, 25, 50, "All"]
		],
		"ordering": false,
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
			},
		}
	});
</script>

<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	});
</script>

<script>
	$(function() {
		$('[data-toggle="popover"]').popover()
	});
</script>

<script>
</script>