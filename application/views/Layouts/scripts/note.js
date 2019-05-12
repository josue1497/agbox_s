$('#assing-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note_id = button.data('note');

    $('#send-button').on('click', function () {
       

        $.post("{{ REASING }}", $('#form-sent').serialize(), function (data, status) {
            console.log(data);
            $('#assing-modal').modal('hide');
            $('#comment').val('');
            location.href='../../note/note_information/'+note_id;
        })
            .fail(function () {
                alert("Ha ocurrido un Error.");
            });

            $("#send-button").unbind("click");
    });

    var modal = $(this)
    modal.find('#note-id').val(note_id);
});

$('#assing-modal').on('hide.bs.modal', function (event) {
    $("#send-button").unbind("click");
});

$('#close-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var note_id = button.data('note');

    $('#send-button2').on('click', function () {
       

        $.post("{{ CLOSED }}", $('#close-form').serialize(), function (data, status) {
            console.log(data);
            $('#close-modal').modal('hide');
            $('#comment').val('');
            location.href='../../note/note_information/'+note_id;
        })
            .fail(function () {
                alert("Ha ocurrido un Error.");
            });

            $("#send-button").unbind("click");
    });

    var modal = $(this)
    modal.find('#note-id').val(note_id);
});

$('#close-modal').on('hide.bs.modal', function (event) {
    $("#send-button").unbind("click");
});