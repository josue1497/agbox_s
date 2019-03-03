<!DOCTYPE html>
<html>
<body>
<div class="container">
	<div id="{{ name_module }}">
		<div class="col-md-8 col-md-offset-2">
			<!--- card --->
<div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">{{ title_module }} List</h6>
                </div>
				<!-- -- -->
                <div class="card-body">
				
			<div class="alert alert-danger text-center" v-if="errorMessage">
				<button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-alert"></span> {{ errorMessage }}
			</div>
			
			<div class="alert alert-success text-center" v-if="successMessage">
				<button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-ok"></span> {{ successMessage }}
			</div>
			
			<button class="btn btn-primary pull-right" @click="showAddModal{{ name_module }} = true"><span class="glyphicon glyphicon-plus"></span> Add New {{ title_module }}</button>
			<table class="table table-bordered table-striped">
				<thead>
					{{ grid_th }}
					<th>Action</th>
				</thead>
				<tbody>
					<tr v-for="param{{ name_module }} in {{ name_module }}">
						{{ grid_tr }}
						<td>
							<button class="btn btn-success" @click="showEditModal{{ name_module }} = true; select{{ name_module }}(param{{ name_module }});"><span class="glyphicon glyphicon-edit"></span> Edit</button> <button class="btn btn-danger" @click="showDeleteModal{{ name_module }} = true; select{{ name_module }}(param{{ name_module }});"><span class="glyphicon glyphicon-trash"></span> Delete</button>

						</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
		</div>

		<!-- Add Modal -->
<div class="myModal" v-if="showAddModal{{ name_module }}">
	<div class="modalContainer">
		<div class="modalHeader">
			<span class="headerTitle">Add New {{ title_module }}</span>
			<button class="closeBtn pull-right" @click="showAddModal{{ name_module }} = false">&times;</button>
		</div>
		<div class="modalBody">
			{{ create_fields }}
		</div>
		<hr>
		<div class="modalFooter">
			<div class="footerBtn pull-right">
				<button class="btn btn-default" @click="showAddModal{{ name_module }} = false"><span class="glyphicon glyphicon-remove"></span> Cancel</button> <button class="btn btn-primary" @click="showAddModal{{ name_module }} = false; save{{ name_module }}();"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
			</div>
		</div>
	</div>
</div>

<!-- Edit Modal -->
<div class="myModal" v-if="showEditModal{{ name_module }}">
	<div class="modalContainer">
		<div class="editHeader">
			<span class="headerTitle">Edit {{ title_module }}</span>
			<button class="closeEditBtn pull-right" @click="showEditModal{{ name_module }} = false">&times;</button>
		</div>
		<div class="modalBody">
			{{ edit_fields }}
		</div>
		<hr>
		<div class="modalFooter">
			<div class="footerBtn pull-right">
				<button class="btn btn-default" @click="showEditModal{{ name_module }} = false"><span class="glyphicon glyphicon-remove"></span> Cancel</button> <button class="btn btn-success" @click="showEditModal{{ name_module }} = false; update{{ name_module }}();"><span class="glyphicon glyphicon-check"></span> Save</button>
			</div>
		</div>
	</div>
</div>

<!-- Delete Modal -->
<div class="myModal" v-if="showDeleteModal{{ name_module }}">
	<div class="modalContainer">
		<div class="deleteHeader">
			<span class="headerTitle">Delete {{ title_module }}</span>
			<button class="closeDelBtn pull-right" @click="showDeleteModal{{ name_module }} = false">&times;</button>
		</div>
		<div class="modalBody">
			<h5 class="text-center">Are you sure you want to Delete?</h5>
			<!--<h2 class="text-center">{{clickMember.user_name}} {{clickMember.user_email}}</h2>-->
		</div>
		<hr>
		<div class="modalFooter">
			<div class="footerBtn pull-right">
				<button class="btn btn-default" @click="showDeleteModal{{ name_module }} = false"><span class="glyphicon glyphicon-remove"></span> Cancel</button> <button class="btn btn-danger" @click="showDeleteModal{{ name_module }} = false; delete{{ name_module }}(); "><span class="glyphicon glyphicon-trash"></span> Yes</button>
			</div>
		</div>
	</div>
</div>

	</div>
</div>

<!-- VUE scripts -->
<script src="{{ base_url }}libs/scripts/vue.js"></script>
<script src="{{ base_url }}libs/scripts/axios.js"></script>
<script>
	{{ script_module }}
</script>
</body>
</html>