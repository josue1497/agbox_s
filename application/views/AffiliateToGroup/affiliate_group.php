       <div id="app">
            <div class="row">
                <div v-for="group in groups">
                    <affiliate-component :name="group.name" :group_photo='group.group_photo' :user="group.user" :id="group.id"></affiliate-component>
                </div>
            </div> 
       </div>

       <script>
//v-bind:src="photo"
// :v-bind:id="group_photo"
           Vue.component('affiliate-component',{
                props : ['group_photo',
                        'name',
                        'user',
                        'id'],
                template : `<div class="col-md-3 p-3 m-2">
                                <div class="card rounded" style="width: 18rem;">
                                <img class="card-img-top img-fluid image"  alt="Card image cap"  id="{{group_photo}}"/>
                                <div class="card-body">
                                       <h5 class="card-title text-center">{{name}}</h5>
                                       <hr />
                                       <div class="d-flex justify-content-center">
                                               <button class="btn btn-primary" v-on:click="sendAffiliationNotification(id,user)">Solicitar Afiliacion</button>
                                       </div>
                                    </div>
                                </div>`,
                methods:{
                    sendAffiliationNotification: function(group_id, user_id){
                    var jqxhr = $.post( "{{ URI_INSERT }}",
                                    {user_id:user_id, group_id:group_id}, function(data, status) {
                                        console.log('inserted');
                                            })
                            .fail(function() {
                                alert( "Ha ocurrido un Error." );
                                            });
                        },
                    getGroupPhoto: function(group_photo){
                        var jqxhr = $.post( "http://localhost/abx_app/affiliateToGroup/get_img",
                                    {group_photo:group_photo}, function(data, status) {
                            console.log( "Data: "+data+"\nEstado: "+status );
                           document.getElementById(group_photo).src=data;
                                            })
                            .fail(function() {
                                alert( "Ha ocurrido un Error." );
                                            });
                                            console.log(jqxhr);
                                          
                        }},
    created:function () { 
       this.getGroupPhoto(this.group_photo);
        // this.group_photo=  item===''?'https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg':item;
        },

           });
       </script>
     

  <script>
    // var urlPosts = 'http://localhost/abx_app/affiliateToGroup/get_data';
    var urlPosts = '{{ URI_DATA }}';
    var app = new Vue({
      el: '#app',
      created: function() {
	    this.getData()
	},
      data : { groups: [] },
      methods: {
	    getData: function() {
	        axios.get(urlPosts).then(response => {
		    this.groups = response.data;
		});
	    }
          }
    });
  </script>