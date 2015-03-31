$(document).ready(function () {

    $('.editor-top-back').click(function () {
        window.location.href = $(this).data('url');
    });

    //position cells
    var positionCells = function () {
        var windowWidth = window.innerWidth;
        var topHeight = $('.editor-top-bar').height();
        var windowHeight = window.innerHeight;
        var titleFieldHeight = $('#input-title').height();

        $('.editor-form').css('width', windowWidth * 0.35);
        $('.editor-body').css('height', windowHeight - topHeight - 1);
        $('#input-text').css('height', windowHeight - topHeight - titleFieldHeight - 16);
    };

    positionCells();

    //save
    $('#btn-save').click(function () {
        var title = $('#input-title').val();
        var text = $('#input-text').val();

        if (title === '' || text === '') {
            swal('Attention!', 'Title and Text must not be empty!', 'warning');
        } else {
            var url = Routing.generate('backend_posts_create');

            $.post(url, {
                sent: 1,
                ajax: 1,
                title: title,
                text: text
            }, function (data) {
                if (data.status === 'error') {
                    swal('Error!', data.message, 'error');
                } else {
                    window.location.href == Routing.generate('backend_posts_collection');
                }
            });
        }
    });

    $(window).resize(function () {
        positionCells();
    });

});