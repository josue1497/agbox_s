
$(document).ready(function () {
    $('.slide-cont').slick({
        dots: true,
        infinite: false,
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

    $('.slide-panels-one').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    dots: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    adaptiveHeight: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    dots: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    adaptiveHeight: true,
                }
            }
        ]
    });
});

$('#group_info_modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var group_id = button.data('group-id')
    var group_name = button.data('group-name') // Extract info from data-* attributes
    var group_desc = button.data('group-desc')

    $.post("{{ URI_DATA }}", { 'group_id': group_id }, function (data, status) {
        var members = '';
        $.each(data, function (point, item) {
            members += "<li class=\"list-group-item\"><span>" + item.user_name + "</span>&nbsp;-&nbsp;<span>" + item.role_name + "</span></li>"

        });

        $('#member-list').html(members);

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

$('#completed-note-info-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note_id = button.data('note');
    var title = button.data('title');
    var summary = button.data('summary');
    var group = button.data('group');
    $('#comment_content').html("");

    $.post("{{ COMMMENT_DATA }}", { 'note_id': note_id }, function (data, status) {
        var members = data;
        $('#comment_content2').html(members);

    })
        .fail(function () {
            alert("Ha ocurrido un Error.");
        });

    var modal = $(this);
    modal.find('.modal-title').text(title);
    modal.find('#summary').text(summary);
    modal.find('#assingment_id').val(note_id);
});

$('#note-info-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note_id = button.data('note');
    var title = button.data('title');
    var summary = button.data('summary');
    var group = button.data('group');
    $('#comment_content').html("");

    $.post("{{ COMMMENT_DATA }}", { 'note_id': note_id }, function (data, status) {
        var members = data;

        $('#comment_content').html(members);

    })
        .fail(function () {
            alert("Ha ocurrido un Error.");
        });

    $('#complete-button').on('click', function () {

        if (message = prompt("¿Esta seguro de haber completado esta asignación?", 'Escriba un comentario para completar.')) {
            $.post("{{ COMPLETE_ASSINGMENT }}", { 'note_id': $('#assingment_id').val(), 'message': message }, function (data) {
                console.log(data);
                console.log(message);
                if ('' !== data && 'fail' !== data) {
                    $('#' + data).remove();
                    $('#note-info-modal').modal('hide');
                    if (!($("#" + group).children().length > 0)) {
                        $("#" + group).append('<li class="list-group-item list-group-item-action border-0""><div class="d-flex ">' +
                            '<div class="p-2 h4 text-info" >ya no posee asignaciones Pendientes</div></div></li>');
                    }
                }
                // $('#add-comment-modal').modal('hide');
                // $('#comment').val('');
                $("#complete-button").unbind("click");
            })
                .fail(function () {
                    alert("Ha ocurrido un Error.");
                });
        }

    });

    $('#reasing-button').on('click', function () {

        if (message = prompt("¿Esta seguro de reasignar esta tarea?", 'Escriba un comentario.')) {
            $.post("{{ REASING_ASSINGMENT }}", { 'note_id': $('#assingment_id').val(), 'message': message }, function (data) {
                console.log(data);
                console.log(message);
                if ('' !== data && 'fail' !== data) {
                    $('#' + data).remove();
                    $('#note-info-modal').modal('hide');
                    if (!($("#" + group).children().length > 0)) {
                        $("#" + group).append('<li class="list-group-item list-group-item-action border-0""><div class="d-flex ">' +
                            '<div class="p-2 h4 text-info" >ya no posee asignaciones Pendientes</div></div></li>');
                    }
                }
                $("#reasing-button").unbind("click");
            })
                .fail(function () {
                    alert("Ha ocurrido un Error.");
                });
        }

    });


    var modal = $(this);
    modal.find('.modal-title').text(title);
    modal.find('#summary').text(summary);
    modal.find('#assingment_id').val(note_id);
});

$('#note-info-modal').on('hide.bs.modal', function (event) {
    $("#reasing-button").unbind("click");
    $("#complete-button").unbind("click");
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

        $("#send-comment").unbind("click");
    });

    var modal = $(this)
    modal.find('#show-note-title').text(title);
    modal.find('#note_id').val(note_id);
    modal.find('#author_id').val(user_id);
});

$('#add-comment-modal').on('hide.bs.modal', function (event) {
    $("#send-comment").unbind("click");
});

