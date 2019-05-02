Vue.component('affiliate-component', {
    props: ['group_photo',
        'name',
        'user',
        'id'],
    template: `<div class="col-md-2 ">
                    <div class="card border-0" style="width: 10rem;">
                    <div class="d-flex justify-content-center">
                   
                        <img class="card-img-top img-fluid image img-group"  alt="Card image cap"  v-bind:id="id"/>
                        <a href="#" data-toggle="modal" data-target="#group_info_modal" v-bind:data-group="id" v-bind:data-name="name" >
                            <i class="fas fa-ellipsis-v text-secondary"></i>
                        </a>
                    </div>
                    <div class="card-body">
                           <div class="d-flex justify-content-center">
                               <h6 class="card-title text-truncate  text-center" data-toggle="tooltip" data-placement="top" v-bind:title="name">{{name}}</h6>
                            </div>
                           <div class="d-flex justify-content-center">
                                 <button v-bind:m_id="id" class="btn btn-primary" v-on:click="sendAffiliationNotification(id,user);affiliated(id);"><small>Solicitar Afiliación</small></button>
                           </div>
                        </div>
                    </div>`,
    methods: {
        sendAffiliationNotification: function (group_id, user_id) {
            var jqxhr = $.post("{{ URI_INSERT }}",
                { user_id: user_id, group_id: group_id }, function (data, status) {

                    console.log(data);
                })
                .fail(function () {
                    alert("Ha ocurrido un Error.");
                });
        },
        getGroupPhoto: function (group_photo, id) {
            var jqxhr = $.post("{{ PHOTO_GETTING }}",
                { group_photo: group_photo }, function (data, status) {
                    if (group_photo === "" || group_photo == null) {
                        document.getElementById(id).src = 'https://i.ibb.co/pKgD4mH/image-group.png'

                    } else {
                        document.getElementById(id).src = data;
                    }
                })
                .fail(function () {
                    alert("Ha ocurrido un Error.");
                });

        },
        affiliated: function (e) {
            console.log(e);
            $('[m_id=' + e + ']').attr('id', 'm_' + e);
            $('#m_' + e).attr('class', 'btn btn-success');
            $('#m_' + e).text('Solicitado');
            $('#m_' + e).attr('disabled', 'disabled');
        }
    },
    created: function () {
        this.getGroupPhoto(this.group_photo, this.id);
    },

});
var urlPosts = '{{ URI_DATA }}';
var app = new Vue({
    el: '#app',
    created: function () {
        this.getData()
    },
    data: { groups: [], fill: false, load: false },
    methods: {
        getData: function () {
            axios.get(urlPosts).then(response => {
                this.fill = !response.data.length > 0;
                this.groups = response.data;
                this.load = false;
            });
        }
    }
});

$('#group_info_modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var group_id = button.data('group')
    var group_name = button.data('name') // Extract info from data-* attributes
    var group_desc = 'Descripcion'//button.data('group-desc')

    // $.post("{{ URI_DATA }}", { 'group_id': group_id }, function (data, status) {
    //     var members = '';
    //     $.each(data, function (point, item) {
    //         members += "<li class=\"list-group-item\"><span>" + item.user_name + "</span>&nbsp;-&nbsp;<span>" + item.role_name + "</span></li>"

    //     });

    //     $('#member-list').html(members);
    //     // $('#leader-list').html(leader);

    //     leader = '';
    //     members = '';
    // })
    //     .fail(function () {
    //         alert("Ha ocurrido un Error.");
    //     });
    var modal = $(this)
    modal.find('.modal-title').text(group_name);
    // modal.find('#group-description').text(group_desc)
});