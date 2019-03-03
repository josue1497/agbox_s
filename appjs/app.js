//aplicacion vue, necesita que se reescriban las 3 variables mencionadas a continuacion, 
//segun el controlador que la este cargando
//entity_api nombre de la clase api para una entidad especifica
//entity_fields campos de la entidad/tabla
//entity_name nombre de la entidad
var app = new Vue({
	el: '#{{ entity_name }}', //'#members'
	data:{
		showAddModal{{ entity_name }}: false,
		showEditModal{{ entity_name }}: false,
		showDeleteModal{{ entity_name }}: false,
		errorMessage: "",
		successMessage: "",
		{{ entity_name }}: [],
		new{{ entity_name }}: { {{ entity_fields }} }, //{ user_name: '', user_email: '',user_password:'' },
		click{{ entity_name }}: {}
	},

	mounted: function(){
		this.getAll{{ entity_name }}();
	},

	methods:{
		getAll{{ entity_name }}: function(){
			axios.get('{{ base_url }}/api/{{ entity_api }}/data_get')
				.then(function(response){
					//console.log(response);
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.{{ entity_name }} = response.data.result;
					}
				});
		},

		save{{ entity_name }}: function(){
			//console.log(app.newMember);
			var memForm = app.toFormData(app.new{{ entity_name }});
			axios.post('{{ base_url }}/api/{{ entity_api }}/data_post', memForm)
				.then(function(response){
					//console.log(response);
					app.new{{ entity_name }} = { {{ entity_fields }} };//{firstname: '', lastname:''};
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message
						app.getAll{{ entity_name }}();
					}
				});
		},

		update{{ entity_name }}(){
			var memForm = app.toFormData(app.click{{ entity_name }});
			axios.post('{{ base_url }}/api/{{ entity_api }}/data_put', memForm)
				.then(function(response){
					//console.log(response);
					app.click{{ entity_name }} = {};
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message
						app.getAll{{ entity_name }}();
					}
				});
		},

		delete{{ entity_name }}(){
			var memForm = app.toFormData(app.click{{ entity_name }});
			axios.post('{{ base_url }}api/{{ entity_api }}/data_delete', memForm)
				.then(function(response){
					//console.log(response);
					app.click{{ entity_name }} = {};
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message
						app.getAll{{ entity_name }}();
					}
				});
		},

		select{{ entity_name }}(param){
			app.click{{ entity_name }} = param;
		},

		toFormData: function(obj){
			var form_data = new FormData();
			for(var key in obj){
				form_data.append(key, obj[key]);
			}
			return form_data;
		},

		clearMessage: function(){
			app.errorMessage = '';
			app.successMessage = '';
		}

	}
});