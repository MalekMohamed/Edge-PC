/**
 * Created by Strix on 7/2/2019.
 */
jQuery(document).ready(function ($) {
    function error_alert(msg) {
        return '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + msg + '</div>';
    }

    site.changeTheme(localStorage.theme);

    function redirect(link, time) {
        window.setTimeout(function () {

            // Move to inbox page after 2 sec
            window.location.href = link;
        }, time);
    }

    function makeid(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#$%@*+-";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        //return text;
        $('.code-secure').val(text);
        console.log(text);
    }

    $('.btn-random').click(function () {
        makeid(10);
    });
    old_console_log = console.log;
    console.log = function () {
        if (DEBUG) {
            old_console_log.apply(this, arguments);
        }
    }
    $('.top-menu-item-xs .dropdown-menu').on({
        "click": function (e) {
            e.stopPropagation();
        }
    });

    $('.report-item-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=report",
            data: $('.report-item-form').serialize(),
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                $(json_res.field).parent().addClass('has-' + json_res.status);
                if (json_res.status == 'error') {
                    $(json_res.field).after(error_alert(json_res.msg));
                    setTimeout(function () {
                        $(json_res.field).next('.alert').fadeOut(300)
                    }, 2000);
                } else {
                    $('.report-item-form')[0].reset();
                    Custombox.close();
                    $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
                }
            }
        });
    });
    $('.register-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=createuser",
            data: $('.register-form').serialize(),
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                $(json_res.field).parent().parent().addClass('has-' + json_res.status);
                if (json_res.status == 'error') {
                    $(json_res.field).after(error_alert(json_res.msg));
                    setTimeout(function () {
                        $(json_res.field).next('.alert').fadeOut(300)
                    }, 2000);
                } else {
                    $('.register-form')[0].reset();
                    redirect(orign + 'index.php', 1000);
                    Custombox.close();
                    $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
                }
            }
        });
    });
    $('.changepassword-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=change-password",
            data: $('.changepassword-form').serialize(),
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                $(json_res.field).parent().parent().addClass('has-' + json_res.status);
                if (json_res.status == 'error') {
                    if (json_res.field == 'All') {
                        $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
                    } else {
                        $(json_res.field).after(error_alert(json_res.msg));
                        setTimeout(function () {
                            $(json_res.field).next('.alert').fadeOut(300)
                        }, 2000);
                    }
                } else {
                    $('.changepassword-form')[0].reset();
                    $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
                }
            }
        });
    });
    $('.login-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=login",
            data: $('.login-form').serialize(),
            success: function (res) {
                var json_res = $.parseJSON(res);
                $(json_res.field).parent().parent().addClass('has-' + json_res.status);
                if (json_res.status == 'error') {
                    $(json_res.field).after(error_alert(json_res.msg));
                    setTimeout(function () {
                        $(json_res.field).next('.alert').fadeOut(300)
                    }, 2000);
                } else {
                    $('.login-form')[0].reset();
                    redirect(orign + 'index.php', 1000);
                    Custombox.close();
                    $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
                }
            }
        });
    });
    // Store Items
    $('.remove-item-button').click(function () {
        $(".remove-item-form #remove-item").val($(this).data('id'));
        $(".remove-item-form .remove-item").text($(this).data('name'));

    });
    $('.decline-item-button').click(function () {
        $(".decline-item-form #decline-item").val($(this).data('id'));
        $(".decline-item-form .decline-item").text($(this).data('name'));

    });
    $('.decline-item-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=decline-item",
            data: $('.decline-item-form').serialize(),
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                Custombox.close();
                if (json_res.status == 'success') {
                    redirect(orign + 'Staff/items', 1000);
                }
                $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
            }
        });
    });
    $('.approve-item-button').click(function () {
        $(".approve-item-form #approve-item").val($(this).data('id'));
        $(".approve-item-form .approve-item").text($(this).data('name'));

    });
    $('.approve-item-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=approve-item",
            data: $('.approve-item-form').serialize(),
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                Custombox.close();
                redirect(orign + 'Staff/items', 1000);
                $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
            }
        });
    });
    $('.edit-item-button').click(function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'post',
            url: base_url + "?request=item",
            data: {id: id, request: "GET"},
            success: function (res) {
                var Item = $.parseJSON(res).Data;
                console.log(Item);
                $(".edit-item-form #item_id").val(Item.ID);
                $(".edit-item-form #item_name").val(Item.Name);
                $('.edit-item-form').find('.bootstrap-select button .filter-option').text(Item.Brand);
                $(".edit-item-form #item_brand").val(Item.Brand);
                $(".edit-item-form #item_category").val(Item.Category);
                $(".edit-item-form #item_price").val(Item.Price);
                $(".edit-item-form #item_cond").val(Item.Cond);
                $(".edit-item-form #item_desc").val(Item.Description);
                if (Item.Status == 4 || Item.Status == 3) {
                    $('#item_status').parent().parent().hide();
                } else {
                    $('#item_status').parent().parent().show();
                    $(".edit-item-form #item_status").val(Item.Status);
                }
            }
        });

    });
    $('.edit-user-button').click(function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'post',
            url: base_url + "?request=getUser",
            data: {id: id, request: "GET"},
            success: function (res) {
                var User = $.parseJSON(res);
                console.log(User);
                $('.edit-user-form #id').val(User.id);
                $('.edit-user-form #username').val(User.Username);
                $('.edit-user-form #password').val(User.Password);
                $('.edit-user-form #email').val(User.Email);
                $('.edit-user-form').find('.bootstrap-select button .filter-option').text(User.Country);
                $('.edit-user-form #register_country').val(User.Country);
                $('.edit-user-form #mobile').val(User.Mobile);
                if (User.Username == $('.userData').text()) {
                    $('.edit-user-form #state').parent().parent().hide();
                } else {
                    $('.edit-user-form #state').parent().parent().show();
                    $(".edit-user-form #state").val(User.State);
                }
            }
        });

    });
    $('.password-toggle').click(function () {
        if ($('.password-toggle').parent().prev('.form-control').attr('type') == 'password') {
            $('.password-toggle').parent().prev('.form-control').attr('type', 'text');
        } else {
            $('.password-toggle').parent().prev('.form-control').attr('type', 'password');
        }
    });
    $('.edit-user-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('.edit-user-form')[0]);
        $.ajax({
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            url: base_url + "?request=edit-user",
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                Custombox.close();
                if (json_res.status == 'success') {
                    redirect(orign + 'Staff/accounts', 1000);
                }
                $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
            }
        });
    });
    $('.edit-item-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('.edit-item-form')[0]);
        $.ajax({
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            url: base_url + "?request=edit-item",
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                Custombox.close();
                if (json_res.status == 'success') {
                    redirect(orign + 'account/manage-item', 1000);
                }
                $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
            }
        });
    });
    $('.remove-item-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=remove-item",
            data: $('.remove-item-form').serialize(),
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                Custombox.close();
                redirect(orign + 'account/manage-item', 1000);
                $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
            }
        });
    });

    $('.add-item-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('.add-item-form')[0]);
        $.ajax({
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            url: base_url + "?request=add-item",
            success: function (res) {
                console.log(res);
                var json_res = $.parseJSON(res);
                $(json_res.field).parent().parent().addClass('has-' + json_res.status);
                if (json_res.status == 'error') {
                    $(json_res.field).after(error_alert(json_res.msg));
                } else {
                    Custombox.close();
                    $.Notification.notify(json_res.status, 'bottom left', 'Notification', json_res.msg);
                }
            }
        });

    });

    function search(data) {
        $.ajax({
            type: 'post',
            url: base_url + "?request=search",
            data: data,
            beforeSend: function () {
                // setting a timeout
                $('.ajax-content').html('');
                $('.ajax-content').html('<div class="block-disabled"><div class="loader-1"></div></div>');
            },
            success: function (res) {
                var json_res = $.parseJSON(res);
                $('.block-disabled').remove();
                console.log(json_res.data);
                if (json_res.data != 'undefined') {
                    $('.ajax-content').data('counter', json_res.data.length);
                    pagination();
                    $.each(json_res.data, function (key, value) {
                            var dom = '<div class="col-md-4 col-xl-3 static-products"><div class="product-list-box thumb ' + value.Brand + ' ' + value.Cond + '"><a class="image-popup" href="' + value.link + '"><img src="' + value.images + '" alt="product-pic" class="thumb-img"></a><div class="price-tag">' + value.Price + ' L.E<br>' + value.Status + '</div><div class="detail"><a href="' + value.link + '" class="text-white price-title m-0"> ' + value.Name + '</a><h5 class="m-0"><span class="text-muted"> ' + value.Category + ' , ' + value.Cond + ', ' + value.Brand + '</span></h5><h5 class="m-b-5">' + value.Date + '</h5></div></div></div>';
                            $(".ajax-content").append(dom);
                    });
                    if (Math.round($('.ajax-content').data('counter') / $('.pag').data('perpage')) <= 1) {
                        $('.bootpag').html('');
                        $('.bootpag').append('<li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li>');
                        $('.bootpag').append('<li data-lp="1" class="active"><a href="javascript:void(0);">1</a></li>');
                        $('.bootpag').append('<li data-lp="1" class="next disabled"><a href="javascript:void(0);">»</a></li>');
                    }
                    $(".ajax-content").attr('data-search', $('.app-search input').val());
                    $('.content-page .content').append('</div></div>');
                }
            }
        });
    }

    $('.app-search').on('submit', function (e) {
        e.preventDefault();
        search($('.app-search').serialize());
    });
    $('.app-search-sm').on('submit', function (e) {
        e.preventDefault();
        search($('.app-search-sm').serialize());
    });
    pagination();
    $('#brand-select').on('change', function (e) {
        e.preventDefault();
        $('#brand').val($('#brand-select').val());
        $('.ajax-content').attr('data-brand', $('#brand-select').val());
        $('.ajax-content .' + $('#brand-select').val()).addClass('matches');
        $('.ajax-content .' + $('#brand-select').val()).removeClass('All');
        $('.ajax-content .All').hide();
        $('.matches').addClass('All');
        $('.matches').removeClass('matches');
        $('.ajax-content .' + $('#brand-select').val()).show();
    });
    $('.sorting-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: base_url + "?request=sort",
            data: $('.sorting-form').serialize(),
            beforeSend: function () {
                // setting a timeout
                $('.ajax-content').html('');
                $('.ajax-content').html('<div class="block-disabled"><div class="loader-1"></div></div>');
            },
            success: function (res) {
                var json_res = $.parseJSON(res);
                $('.block-disabled').remove();
                $('.ajax-content').data('sort', $('#status-select').val());
                $('.ajax-content').data('counter', json_res.length);
                $('.ajax-content').data('brand', $('#brand-select').val());
                $('.static-products').remove();
                pagination();
                $.each(json_res, function (key, value) {
                    var dom = '<div class="col-md-4 col-xl-3 static-products "><div class="product-list-box thumb  ' + value.Brand + ' ' + value.Cond + '"><a class="image-popup" href="' + value.link + '"><img src="' + value.images + '" alt="product-pic" class="thumb-img"></a><div class="price-tag">' + value.Price + ' L.E<br>' + value.Status + '</div><div class="detail"><a href="' + value.link + '" class="text-white price-title m-0"> ' + value.Name + '</a><h5 class="m-0"><span class="text-muted"> ' + value.Category + ' , ' + value.Cond + ', ' + value.Brand + '</span></h5><h5 class="m-b-5">' + value.Date + '</h5></div></div></div>';
                    $(".ajax-content").append(dom);
                });
                if (Math.round($('.ajax-content').data('counter') / $('.pag').data('perpage')) <= 1) {
                    $('.bootpag').html('');
                    $('.bootpag').append('<li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li>');
                    $('.bootpag').append('<li data-lp="1" class="active"><a href="javascript:void(0);">1</a></li>');
                    $('.bootpag').append('<li data-lp="1" class="next disabled"><a href="javascript:void(0);">»</a></li>');
                }
            }
        });
    });

    function pagination() {
        if ($('#brand-select').val() == 'All') {
            $('.ajax-content').data('brand', 'All');
        }
        console.log($('.ajax-content').data('counter'));
        $('.pag').bootpag({
            total: $('.ajax-content').data('counter'),
            page: 1,
            leaps: false,
            maxVisible: Math.ceil($('.ajax-content').data('counter') / $('.pag').data('perpage'))
        }).on('page', function (event, num) {

            $('li.next').attr('data-lp', num + 1);
            $('li.next').html('<a href="javascript:void(0);">»</a>');
            //console.log($('.ajax-content').data('brand'));
            $.ajax({
                type: 'post',
                url: base_url + "?request=Page",
                beforeSend: function () {
                    // setting a timeout
                    $('.ajax-content').html('');
                    $('.ajax-content').html('<div class="block-disabled"><div class="loader-1"></div></div>');
                },
                data: {request: $('.ajax-content').data(), page: num},
                success: function (res) {
                    var json_res = $.parseJSON(res);
                    $('.static-products').remove();
                    $('.block-disabled').remove();
                    if (json_res.length != 0 || (json_res.length / $('.pag').data('perpage')) > 1) {

                        $.each(json_res, function (key, value) {
                            var dom = '<div class="col-md-4 col-xl-3 static-products"><div class="product-list-box thumb  ' + value.Brand + ' ' + value.Cond + ' "><a class="image-popup" href="' + value.link + '"><img src="' + value.images + '" alt="product-pic" class="thumb-img"></a><div class="price-tag">' + value.Price + ' L.E<br>' + value.Status + '</div><div class="detail"><a href="' + value.link + '" class="text-white price-title m-0"> ' + value.Name + '</a><h5 class="m-0"><span class="text-muted"> ' + value.Category + ' , ' + value.Cond + ', ' + value.Brand + '</span></h5><h5 class="m-b-5">' + value.Date + '</h5></div></div></div>';
                            $(".ajax-content").after().append(dom);
                        });
                    } else {
                        $('.bootpag li.active').nextAll('li').hide();
                        $('li.next').show();
                        $('li.next').addClass('disabled');
                        $('li.next').attr('data-lp', Math.ceil($('.ajax-content').data('counter') / $('.pag').data('perpage')));
                    }

                }
            });
            //$(".ajax-content").html("Page " + num); // or some ajax content loading...
        });
    }

    $('.chat-form').on('submit', function (e) {
        e.preventDefault();
        chat.send($('.chat-form').serialize());
    })
});
var chat = {
    send: function (form) {
        $(document).ready(function () {
            var info = {
                msg: $('.chat-input').val(),
                sender: $('.chat-data').attr('data-sender'),
                receiver: $('.chat-data').attr('data-receiver'),
                id: $('.chat-data').attr('data-adID')
            };
            $('<li class="clearfix odd"><div class="chat-avatar"><img data-toggle="tooltip" data-placement="left" title="" data-original-title="Me" src="' + $('.my-avatar').attr('src') + '" alt="' + $('.my-avatar').attr('alt') + '" width="45" height="45"></></div><div class="conversation-text"><div class="ctext-wrap" data-placement="right" data-toggle="tooltip" data-original-title="Just now"><p>' + $('.chat-input').val() + '</p></div></div></li>').appendTo("ul.conversation-list");
            $('.chat-input').val('');
            $(".conversation-list").animate({scrollTop: $('.conversation-list').prop("scrollHeight")}, 1000);
            $.ajax({
                type: 'post',
                url: base_url + '?request=add_msg',
                data: info,
                success: function (res) {
                    var obj = jQuery.parseJSON(res);
                    console.log(obj);
                    if (obj.status == 'success') {
                        $.Notification.autoHideNotify(obj.status, 'bottom left', 'Message Sent', obj.message);

                    } else {
                        $.Notification.autoHideNotify(obj.status, 'bottom left', 'Message Error', obj.message);
                    }

                }
            });
        })
    },
    get_new: function () {
        $(document).ready(function () {
            var info = {
                sender: $('.chat-data').attr('data-sender'),
                receiver: $('.chat-data').attr('data-receiver'),
                id: $('.chat-data').attr('data-adID')
            };
            $.ajax({
                type: 'post',
                url: base_url + '?request=get_msgs',
                data: info,
                success: function (res) {
                    var obj = jQuery.parseJSON(res);
                    if (obj.status == 'white' && obj.number != 0) {
                        console.log(obj);
                        $.each(obj.data, function (key, value) {
                            if (value.userID == info.receiver) {
                                $('<li class="clearfix"><div class="chat-avatar"><a href="' + $('.chat-profile').attr('href') + '"><img data-toggle="tooltip" data-placement="left" title="" data-original-title="' + $('.user-avatar').attr('alt') + '" src="' + $('.user-avatar').attr('src') + '" alt="' + $('.user-avatar').attr('alt') + '" width="45" height="45"></a></div><div class="conversation-text"><div class="ctext-wrap" data-placement="right" data-toggle="tooltip" data-original-title="' + $('.user-avatar').attr('alt') + ' ' + value.date + '"><p>' + value.message + '</p></div></div></li>').appendTo("ul.conversation-list");
                            }
                        });
                        $(".conversation-list").animate({scrollTop: $('.conversation-list').prop("scrollHeight")}, 1000);
                        setTimeout(function () {
                            chat.update();
                        }, 1500);
                    }
                }
            });
        })
    },
    update: function () {
        $(document).ready(function () {
            var info = {
                sender: $('.chat-data').attr('data-sender'),
                receiver: $('.chat-data').attr('data-receiver'),
                id: $('.chat-data').attr('data-adID')
            };
            $.ajax({
                type: 'post',
                url: base_url + '?request=update_new_msgs',
                data: info,
                success: function (res) {
                    console.log('Message Updated' + res);
                }
            });
        })
    }
};
var notifications = {
    update: function (status) {
        $(document).ready(function () {
            $.ajax({
                type: 'post',
                url: base_url + '?request=update_notification',
                data: {status: status},
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.status == 'success') {
                        console.log(obj);
                        $('.badge').hide();
                    } else {
                        $.Notification.autoHideNotify(obj.status, 'bottom left', 'Error', obj.msg);
                    }
                }

            });
        });

    },
    new_notifications: function () {
        $(document).ready(function () {
            var info = {
                user: $('.upcoming').attr("data-user")
            };
            $.ajax({
                type: 'post',
                url: base_url + '?request=get_last_notification',
                data: info,
                success: function (res) {

                    var obj = jQuery.parseJSON(res);

                    if (obj.number != 0) {
                        console.log(obj.number + ' New Notifications');
                    }
                    if (obj.status == 'white' && obj.number != 0) {
                        console.log(obj);
                        $('.upcoming_badge').show();
                        $('.upcoming_badge').text(parseInt($('.upcoming_badge').text()) + obj.number);
                        $('.upcoming').show();
                        $.each(obj.data, function (key, value) {
                            console.log(value.title);
                            var doc = '<a href="javascript:void(0);" data-user="' + value.touser + '" data-id="' + value.id + '" style="" class="list-group-item new"><div class="media"> <div class="pull-left p-r-10"><em class="notif-icon fa noti-primary fa-envelope-o"></em></div><div class="media-body"><h5 class="media-heading notif-title">' + value.title + '</h5><p class="m-0"><small class="notif-time">' + value.time + '</small></p></div></div></a>';
                            $(doc).appendTo("ul.notification-list");

                        });
                        $.Notification.autoHideNotify(obj.status, 'bottom left', 'You have ' + obj.number + ' New Notification', '');

                    }

                }
            });
        })
    }
};
var site = {
    changeTheme: function (Theme) {
        $(document).ready(function () {
            localStorage.auto_saved_sql = '';
            localStorage.theme = Theme;
            console.log(localStorage.theme);
            $('#core-css').attr('href', orign + 'public/assets/css/' + Theme + '/core.css');
            $('#custom-css').attr('href', orign + 'public/assets/css/' + Theme + '/custom.css');
            $('#pages-css').attr('href', orign + 'public/assets/css/' + Theme + '/pages.css');
            $('#components-css').attr('href', orign + 'public/assets/css/' + Theme + '/components.css');
            if (Theme == 'dark') {
                $('#ThemeColor').attr('onchange', 'changeTheme(\'light\');');
                $('#ThemeColor').attr('checked', true);
                $('#ThemeColor').parent().find(".switchery").attr('style', 'box-shadow: rgb(240, 80, 80) 0px 0px 0px 11px inset; border-color: rgb(240, 80, 80); background-color: rgb(240, 80, 80); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;');
                $('#ThemeColor').parent().find("small").attr('style', 'left: 13px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s; background-color: rgb(255, 255, 255); right: 0px;');
            } else {
                $('.btn-white').addClass('btn-inverse');
                $('.btn-white').removeClass('btn-btn-white');
                $('#ThemeColor').attr('onchange', 'changeTheme(\'dark\');');
                $('#ThemeColor').attr('checked', false);
                $('#ThemeColor').parent().find(".switchery").attr('style', 'box-shadow: rgb(235, 239, 242) 0px 0px 0px 0px inset; border-color: rgb(235, 239, 242); background-color: rgb(235, 239, 242); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;');
                $('#ThemeColor').parent().find("small").attr('style', 'left: 0px; transition: background-color 0.4s ease 0s, right 0.2s ease 0s; background-color: rgb(255, 255, 255); right: 13px;');
            }

        });
    }
};

function changeTheme(Theme) {
    $.ajax({
        type: 'post',
        url: base_url + "?request=changeTheme",
        data: {Color: Theme},
        success: function (res) {
            site.changeTheme(Theme);
            window.setTimeout(function () {
                window.location.href
            }, 100);
        }
    });

}