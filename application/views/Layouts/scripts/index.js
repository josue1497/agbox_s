
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

    $.post("{{ URI_DATA }}", { 'group_id': group_id }, function (data, status) {
        var members = '';
        var leader = '';
        $.each(data, function (point, item) {
            if ('Lider' !== item.role_name) {
                members += "<li class=\"list-group-item\"><span>" + item.user_name + "</span>&nbsp;-&nbsp;<span>" + item.role_name + "</span></li>"
            } else {
                leader += "<li class=\"list-group-item\">" + item.user_name + "<\/li>"
            }


            console.log(item);
        });

        $('#member-list').html(members);
        $('#leader-list').html(leader);

        leader = '';
        members = '';
    })
        .fail(function () {
            alert("Ha ocurrido un Error.");
        });
    var modal = $(this)
    modal.find('.modal-title').text(group_name);
    modal.find('#group-description').text(group_desc)
});

$('#note-info-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note_id = button.data('note');
    var title = button.data('title');
    var summary = button.data('summary');
    $('#comment_content').html("");

    $.post("{{ COMMMENT_DATA }}", { 'note_id': note_id }, function (data, status) {
        var members = data;

        $('#comment_content').html(members);

    })
        .fail(function () {
            alert("Ha ocurrido un Error.");
        });

    $('#complete-button').on('click', function () {
        $.post("{{ COMPLETE_ASSINGMENT }}", {'note_id':$('#assingment_id').val()}, function (data, status) {
            console.log(data);
            // $('#add-comment-modal').modal('hide');
            // $('#comment').val('');
        })
            .fail(function () {
                alert("Ha ocurrido un Error.");
            });
    });


    var modal = $(this);
    modal.find('.modal-title').text(title);
    modal.find('#summary').text(summary);
    modal.find('#assingment_id').val(note_id);
});

$('#add-comment-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note_id = button.data('note');
    var user_id = button.data('author');
    var title = button.data('title');

    $('#send-comment').on('click', function () {
        $.post("{{ SEND_COMMENT }}", $('#form_comment').serialize(), function (data, status) {
            console.log(data);
            $('#add-comment-modal').modal('hide');
            $('#comment').val('');
        })
            .fail(function () {
                alert("Ha ocurrido un Error.");
            });
    });

    var modal = $(this)
    modal.find('#show-note-title').text(title);
    modal.find('#note_id').val(note_id);
    modal.find('#author_id').val(user_id);
});
