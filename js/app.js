$(document).ready(function () {

    getComments();

    user = localStorage.getItem('user');

    if (user) {
        user = JSON.parse(user);
        loginBySecret(user[0]['username'], user[0]['secret']);
    }

    function getComments() {

        $.get('/app/getComments.php/', function (data) {
            setTimeout(function () {
                renderComments(data)
            }, 1500);
        });
    }

    function renderComments(data) {
        $('#comment-list').html(data);
    }

    $('.btn-login').on('click', function () {
        var username = $('#login-username').val();
        var password = $('#login-password').val();
        login(username, password);
        return false;
    });

    $('.btn-register').on('click', function () {
        var username = $('#register-username').val();
        var password = $('#register-password').val();
        register(username, password);
        return false;
    })

    $('#logout').on('click', function () {
        logout();
        return false;
    })

    $('#login-show').on('click', function () {
        show_blocks(['#login']);
        hide_blocks(['#register']);
        return false;
    });

    $('#comment-list').on('click', '.btn-deleteComment', function () {
        $(this).removeClass('btn-deleteComment');
        $(this).html('<img height="30px" src="/css/126.gif">');
        deleteComment($(this).data('commentid'));
        return false;
    });

    $('#register-show').on('click', function () {
        show_blocks(['#register']);
        hide_blocks(['#login']);
        return false;
    });

    $('#add-comment').on('click', function () {
        var text = $('#comment-text').val();
        addComment(text);
    });

    $('#comment-list').on('click', '.answer-comment', function () {
        $('.add-answer-field').show();
    })

    $('#comment-list').on('click', '.answer-add', function () {
        var text = $( '#answer-text-' + $(this).data('commentid') ).val();
        addAnswer(text, $(this).data('commentid'));
    })

    $('#comment-list').on('click', '.answer-delete', function () {
        var answer_id = $(this).data('answerid');
        deleteAnswer(answer_id);
        return false;
    })

    function show_blocks(blocks) {
        blocks.forEach(function (value , i) {
            $(value).show();
            $(value).addClass('asdasd');
        });
    }

    function hide_blocks(blocks) {
        blocks.forEach(function (value , i) {
            $(value).hide();
        });
    }

    function login(username, password) {
        $.get('/app/login.php/?action=login&username=' + username + '&password=' + password, function (data) {
            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data[0]['role'] == '222') {
                show_admin();
            }
            
            show_blocks(['#logout', '#comment-area']);
            hide_blocks(['#login-show', '#register-show', '#login']);
            $('#username').html(data[0]['username']);

            localStorage.setItem('user', JSON.stringify(data));

        });
    }

    function loginBySecret(username, secret) {
        $.get('/app/loginBySecret.php/?action=loginBySecret&username=' + username + '&secret=' + secret, function (data) {
            data = JSON.parse(data);

            if (data['error']) {
                return false;
            }

            if (data[0]['role'] == '222') {
                $('#comment-list').addClass('isAdmin');
            }

            $('#username').html(data[0]['username']);
            show_blocks(['#logout', '#comment-area']);
            hide_blocks(['#login-show', '#register-show', '#login']);

        });
    }


    function register(username, password) {
        $.get('/app/register.php/?action=register&username=' + username + '&password=' + password, function (data) {
            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data['message']) {
                alert(data['message']);
            }

            show_blocks(['#login']);
            hide_blocks(['#register']);

        });
    }

    function logout() {

        $.get('/app/logout.php', function (data) {

            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data['message']) {
                hide_blocks(['#logout', "#comment-area"]);
                show_blocks(['#login-show', '#register-show']);
                hide_admin();
                localStorage.removeItem('user');
            }
        });
    }

    function addComment(text) {

        $.get('/app/addComment.php/?action=add-comment&text=' + text, function (data) {

            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data['message']) {
                getComments();
            }
        });
    }

    function addAnswer(text, commentId) {
        $.get('/app/addAnswer.php/?&text=' + text + '&commnetId=' + commentId, function (data) {

            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data['message']) {
                getComments();
            }
        })
    }

    function deleteComment(id) {

        $.get('/app/deleteComment.php/?comment_id=' + id, function (data) {

            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data['message']) {
                getComments();
            }
        });
    }

    function deleteAnswer(answer_id) {

        $.get('/app/deleteAnswer.php/?answer_id=' + answer_id, function (data) {

            data = JSON.parse(data);

            if (data['error']) {
                alert(data['error']);
                return false;
            }

            if (data['message']) {
                getComments();
            }
        });
    }





    function show_admin() {
        show_blocks(['body .admin-control']);
    }

    function hide_admin() {
        hide_blocks(['body .admin-control']);
    }

});