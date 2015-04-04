$(document).ready(function () {

    //ace
    var editor = ace.edit("input-about");
    editor.setTheme("ace/theme/github");
    editor.getSession().setMode("ace/mode/markdown");
    editor.getSession().setTabSize(4);
    document.getElementById('input-about').style.fontSize = '16px';

    //save user
    $('#form-user').submit(function (e) {
        e.preventDefault();

        var firstName = $('#input-firstname').val();
        var lastName = $('#input-lastname').val();
        var email = $('#input-email').val();
        var about = editor.getValue();

        var url = Routing.generate('backend_users_update', {
            userId: $(this).data('id')
        });

        $.post(url, {
            sent: 1,
            ajax: 1,
            firstname: firstName,
            lastname: lastName,
            email: email,
            about: about
        }, function (data) {
            if (data.status === 'error') {
                swal('Error!', data.message, 'error');
            } else {
                swal({
                    title: 'Success!',
                    text: data.message,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: "#5cb85c",
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                }, function () {
                    window.location.href = Routing.generate('backend_users_collection');
                });
            }
        });
    });

});