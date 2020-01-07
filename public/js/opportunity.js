var hasData = true;
var isLoading = false;


$("#opportunity-create").submit(function(e) {
    e.preventDefault();
});

$("button#btn-opr-later, button#btn-opr-cont").on("click", function() {
    var data_array = $("#opportunity-create").serializeArray();
    let btnVal = $(this).val();
    $.ajax({
        type: "POST",
        url: SITE_URL + "/add-opportunity",
        data: data_array,
        success: function(data) {
            $('.invalid-feedback').hide()
            if (data.status == false) {
                $.each(data.message, function(index, value) {
                    var error_elem = $("#" + index).closest(".form-group").find(".invalid-feedback");
                    error_elem.show()
                    error_elem.text(value);
                });
            } else if (data.status == true) {
                if (btnVal == "continue") {
                    window.location.href = SITE_URL + "/create-opportunity/" + data.enc_oid;
                } else {
                    $('#mainPage__createOpportunity').modal('hide');
                    $('#opportunity__success').modal('show');
                }
            }
        },
        error: function() {
            alert('ACK ajax error!')
        }
    });
});

$('#message').on('keyup', function() {
    $('#error-message').hide();
});
$('#user_id').on('change', function() {
    $('#error-user_id').hide();
});

$(document).on('submit', "#acknowledgeForm", function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);

    $.ajax({
        type: "POST",
        url: SITE_URL + "/acknowledge",
        data: form.serializeArray(), // serializes the form's elements.
        beforeSend: function() {},
        error: function() {
            alert('ACK ajax error!')
        },
        success: function() {
            $('.invalid-feedback').hide()
        },
        complete: function(data) {
            var obj = $.parseJSON(data.responseText);
            if (obj.type == 'success') { //console.log(obj)
                //$('#mainPage__acknowledgeAnExpert .modal-content').html(obj.success_html);
                $('#acknowledge').addClass('hidden');
                $('#thanks_up').html(obj.success_html);
                $('#thanks_up').removeClass('hidden');
                setTimeout(function() {
                    //$('#mainPage__acknowledgeAnExpert').modal('toggle')
                    $('#mainPage__acknowledgeAnExpert').modal('hide');
                }, 2000);
            } else {
                jQuery.each(obj.keys, function(key, value) {
                    var error_msg = obj.errors[key] //console.log("#"+value)
                    var error_elem = $("#" + value).closest(".form-group").find(".invalid-feedback");
                    error_elem.show()
                    error_elem.text(error_msg);
                });
            }
        },
    });


});

function sortWidget(slug, sortby) {
    $.ajax({
        type: "POST",
        url: SITE_URL + "/sort-widget",
        data: { slug: slug, sortby: sortby },
        beforeSend: function() {},
        error: function() {
            alert('SORT ajax error!')
        },
        success: function() {},
        complete: function(data) {
            var obj = $.parseJSON(data.responseText);
            if (obj.type == 'success') { //console.log(obj)
                $('#' + slug).html(obj.success_html);

            } else {}
        },
    })
}

$(document).ready(function() {



    $(document).on('click', '#acknowledgeAnExpert', function() {
        /*$('#acknowledge').removeClass('hidden');
        $('#thanks_up').addClass('hidden');
        $('#error-message').hide();
        $('#error-user_id').hide();
        $('#user_id').val('');
        $('#message').val('');
        $('#mainPage__acknowledgeAnExpert').modal('show'); */


        var modal = $(this).data("target")
            //console.log(modal)
        $.ajax({
            url: SITE_URL + '/ack-form',
            type: "GET",
            data: {},
            beforeSend: function() {
                $(modal).find('.modal-body').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
            },
            error: function() {},
            success: function() {},
            complete: function(data) {
                var obj = $.parseJSON(data.responseText); //console.log(obj.html)
                $('#' + modal).find('.modal-body').html(obj.html);
                $('#' + modal).modal('show');
            },
        });
    });
});

$('body').on('keyup', '.frminput', function() {
    var org_id = $(this).attr('id');
    $("#" + org_id + '-error').hide();
    $("#" + org_id + '-error').text("");
});

$('body').on('click', '.submit_comment', function() {
    var org_id = $(this).data('id');
    var comment = $('#comment' + org_id).val();
    var type = $(this).data('type');
    if (comment != '') {
        $.ajax({
            url: SITE_URL +"/add_comment",
            type: "POST",
            dataType: 'json',
            data: { comment: comment, org_id: org_id, type: 'comment', ptype: type },
            beforeSend: function() {},
            error: function() {},
            success: function() {},
            complete: function(data) {
                if (data.status == 200) {
                    $('#comment' + org_id).val('');
                    get_comment(org_id, type);
                }
            },
        });
    } else {
        var error_elem = $("#comment" + org_id).parent().next().find(".invalid-feedback");
        $("#comment" + org_id + '-error').show();
        $("#comment" + org_id + '-error').text("This field is required.");
    }
});

$('body').on('click', '.submit_reply', function() {
    var org_id = $(this).data('org_id');
    var id = $(this).data('id');
    var cid = $(this).data('cid');
    var type = $(this).data('type');
    var comment = $('#reply_' + type + id).val();
    if (comment != '') {
        $.ajax({
            url: SITE_URL +"/add_comment",
            type: "POST",
            dataType: 'json',
            data: { comment: comment, org_id: org_id, id: cid, type: 'reply', ptype: type },
            beforeSend: function() {},
            error: function() {},
            success: function() {},
            complete: function(data) {
                if (data.status == 200) {
                    $('#replyCollapsibleComment_' + type + id).removeClass('show');
                    $('#replyCollapsibleCommentSecondary_' + type + id).removeClass('show');
                    $('#reply_' + type + id).val('');
                    $('#viewAllReplies_' + type + cid).append(data.responseJSON.comments);

                }
            },
        });
    } else {
        var error_elem = $("#reply_" + type + id).parent().next().find(".invalid-feedback");
        $("#reply_" + type + id + '-error').show();
        $("#reply_" + type + id + '-error').text("This field is required.");
    }
});

$('body').on('click', '.opp-comment', function() {
    var org_id = $(this).data('fid');
    var type = $(this).data('type');
	$('#comment'+org_id+'-error').css('display','none');
    if ($('#collapsibleComment_' + type + org_id).is(":visible")) {
        $('#collapsibleComment_' + type + org_id).hide("slow", "swing");
    } else {
        get_comment(org_id, type);
        $('#collapsibleComment_' + type + org_id).show("slow", "swing");
    }
});

$('body').on('click', '.load_prev_reply', function() {
    var parent_id = $(this).data('id');
    var org_id = $(this).data('org_id');
    var type = $(this).data('type');
    var prev_id = $('#lastReplyid_' + type + parent_id).val();
    $('.replybox' + parent_id).jmspinner('small');
    $.ajax({
        url: SITE_URL +"/get_more_reply",
        type: "POST",
        dataType: 'json',
        data: { parent_id: parent_id, org_id: org_id, prev_id: prev_id, type: type },
        beforeSend: function() {},
        error: function() {},
        success: function() {},
        complete: function(data) {
            if (data.responseJSON.status == true) {
                if (data.responseJSON.count == 1) {
                    $('#viewAllReplies_' + type + parent_id).prepend(data.responseJSON.comments);
                    $('#lastReplyid_' + type + parent_id).val(data.responseJSON.last_key);
                } else {
                    $('#load_prev_reply_' + type + parent_id).html('');
                }
            }
            $('.replybox' + parent_id).jmspinner(false);
        },
    });
});

$('body').on('click', '.load_more_comment', function() {
    $('.commentbox').jmspinner('small');
    var org_id = $(this).data('org_id');
    var type = $(this).data('type');
    var prev_id = $('#lastComments_' + type + org_id).val();
    $.ajax({
        url: SITE_URL +"/get_more_comment",
        type: "POST",
        dataType: 'json',
        data: { org_id: org_id, prev_id: prev_id, type: type },
        beforeSend: function() {},
        error: function() {},
        success: function() {},
        complete: function(data) {
            if (data.responseJSON.status == true) {
                if (data.responseJSON.count == 1) {
                    $('.cmn-feed-card__load-more-replies').remove();
                    $('#show_comments_' + type + org_id).append(data.responseJSON.comments);
                } else {
                    $('#load_more_comment_' + type + org_id).addClass('hidden');
                }
            }
            $('.commentbox').jmspinner(false);
        },
    });
});


function get_comment(org_id, type = 'opportunity') {
    $('.commentbox').jmspinner('small');
    $.ajax({
        url: SITE_URL +"/get_comment",
        type: "POST",
        dataType: 'json',
        data: { org_id: org_id, type: type },
        beforeSend: function() {},
        error: function() {},
        success: function() {},
        complete: function(data) {
            //var vdata = JSON.stringify(data.responseText);
            //console.log(data);alert(data.responseJSON.status);
            if (data.responseJSON.status == true) { //alert(data.responseJSON.comments);
                $('#show_comments_' + type + org_id).html(data.responseJSON.comments);
            }
            $('.commentbox').jmspinner(false);
        },
    });

}
