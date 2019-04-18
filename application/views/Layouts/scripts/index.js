
$(document).ready(function () {
    $('.slide-cont').slick({
        dots: true,
        infinite: true,
        speed: 1000,
        slidesToShow: 8,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ],
    });
});

$('#group_info_modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var group_id = button.data('group-id') 
    var group_name = button.data('group-name') // Extract info from data-* attributes
    var group_desc = button.data('group-desc')

    $.post("{{ URI_DATA }}",{'group_id':group_id}, function (data, status) {
        var members='';
        var leader='';
            $.each(data, function(point,item){
                if('Lider'!==item.role_name){
                    members+="<li class=\"list-group-item\"><span>"+item.user_name+"</span>&nbsp;-&nbsp;<span>"+item.role_name+"</span></li>"
                }else{
                    leader+="<li class=\"list-group-item\">"+item.user_name+"<\/li>"
                }
                

                console.log(item);
            });

            $('#member-list').html(members);
            $('#leader-list').html(leader);

            leader='';
            members='';
        })
        .fail(function () {
            alert("Ha ocurrido un Error.");
        });
    var modal = $(this)
    modal.find('.modal-title').text(group_name);
    modal.find('#group-description').text(group_desc)
});
