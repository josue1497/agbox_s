<?php
/**
 * Clase que maneja la afiliacion de usuarios a algun grupo.
 */
class affiliate_to_groupController extends Controller{
    /**
     * metodo accion dashboard
     * 
     * @return void
     */
    function items(){
		$this->init(new Affiliate());
		
        $js=" Vue.component('affiliate-component',{
            props : ['group_photo',
                    'name',
                    'user',
                    'id'],
            template : `<div class=\"col-md-3 p-3 m-2\">
                            <div class=\"card rounded \" style=\"width: 18rem;\">
                            <img class=\"card-img-top img-fluid image img-group\"  alt=\"Card image cap\"  v-bind:id=\"id\"/>
                            <div class=\"card-body\">
                                   <h5 class=\"card-title text-center\">{{name}}</h5>
                                   <hr />
                                   <div class=\"d-flex justify-content-center\">
                                           <button class=\"btn btn-primary\" v-on:click=\"sendAffiliationNotification(id,user);affiliated(this);\">Solicitar Afiliacion</button>
                                   </div>
                                </div>
                            </div>`,
            methods:{
                sendAffiliationNotification: function(group_id, user_id){
                var jqxhr = $.post( \"{{ URI_INSERT }}\",
                                {user_id:user_id, group_id:group_id}, function(data, status) {
                                    console.log('inserted');
                                        })
                        .fail(function() {
                            alert( \"Ha ocurrido un Error.\" );
                                        });
                    },
                getGroupPhoto: function(group_photo,id){
                    var jqxhr = $.post( \"".SERVER_DIR."affiliate_to_group/get_img\",
                                {group_photo:group_photo}, function(data, status) {
                        if(group_photo===\"\"){
                            document.getElementById(id).src='https://t4.ftcdn.net/jpg/02/15/84/43/240_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg'
                        }else{
                       document.getElementById(id).src=data;
                        }
                                        })
                        .fail(function() {
                            alert( \"Ha ocurrido un Error.\" );
                                        });
                                      
                    },
                    affiliated: function (event){
                        console.log(event.target);
                    }},
created:function () { 
   this.getGroupPhoto(this.group_photo, this.id);
    },

       });
var urlPosts = '{{ URI_DATA }}';
var app = new Vue({
  el: '#app',
  created: function() {
    this.getData()
},
  data : { groups: [],fill:false,load:false },
  methods: {
    getData: function() {
        axios.get(urlPosts).then(response => {
        this.fill=!response.data.length>0;
        this.groups = response.data;
        this.load=false;
    });
    }
      }
});";
        $js = str_replace('{{ URI_DATA }}',SERVER_DIR."affiliate_to_group".'/get_data',$js);
        $js = str_replace('{{ URI_INSERT }}',SERVER_DIR."affiliate_to_group".'/insert_data',$js);


        $this->view->add_script_js($js);

        $this->model->table_label = 'Afiliacion a Grupos';
        $this->render("items");

    }

    function get_data(){
        $data = Model::get_sql_data("select G.*, ? as user from groups G where id not in (select group_id from affiliate where user_id=?)",
                            array('user_id'=>Session::get('user_id'),'user_id2'=>Session::get('user_id')));
        header('Content-Type: application/json');
        echo json_encode($data,JSON_PRETTY_PRINT);
    }

    function insert_data(){  
        $this->model = new Affiliate();
        echo $this->model->create($_POST); 
    }

    function get_img(){
      $photo= Component::img_to_base64(UPLOADS_DIR.$_POST['group_photo']);
      echo $photo;
    }
}
?>