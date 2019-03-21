       <div id="app">
            <div class="row">
                <div v-for="group in groups">
                    <affiliate-component group-name="group.photo_profile"></affiliate-component>
                </div>
            </div> 
       </div>

       <script>
           Vue.component('affiliate-component',{
                props : {'group-img':{type:String, default:''},
                        'group-name':{type:String, default:''},
                        'user-id':{type:String, default:''},
                        'group-id':{type:String, default:''}},
                template : '<div class="col-md-3 p-3 m-2">'+
                                '<div class="card rounded" style="width: 18rem;">'+
                                '<img class="card-img-top img-fluid image" v-bind:group-img:"group-img" alt="Card image cap"  id="group-icon"/>'+
                                '<div class="card-body">'+
                                '       <h5 class="card-title text-center">{{group-name}}</h5>'+
                                '       <hr />'+
                                '       <div class="d-flex justify-content-center">'+
                                '               <button class="btn btn-primary" v-on:click="sendAffiliationNotification()">Solicitar Afiliacion</button>'+
                                '       </div>'+
                                '    </div>'+
                                '</div>',
                methods:{sendAffiliationNotification: function(group_id, user_id){
                    console.log(group_id);
                    console.log(user_id);
                }},
           });
       </script>
     

  <script>
    var urlPosts = 'http://localhost/abx_app/affiliateToGroup/get_data';
    var app = new Vue({
      el: '#app',
      created: function() {
	    this.getData()
	},
      data : { groups: [] },
      methods: {
	    getData: function() {
	        axios.get(urlPosts).then(response => {
		    this.groups = response.data
		});
	    }
          }
    });
  </script>