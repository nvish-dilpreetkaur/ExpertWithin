/** like/dislike code : starts **/
$(document).on('click', "a[class^='likeBtn']", function(e) {
    e.stopPropagation();
    var action = $(this).attr('data-action')
    var feed_id = $(this).attr('data-feed_id')
    var elem = $(this)

    var pdata = { 'action': action, 'feed_id': feed_id };
    //console.log(url)
    performFeedAction(elem, pdata);
});
/** like/dislike code : ends **/

$(document).on('click', "#show_more_notifications", function(e) {
    e.stopPropagation();
	window.location = SITE_URL+'/notifications';
});


/** fav/unfav code : starts **/
$(document).on('click', "a[class^='favBtn']", function(e) {
    e.stopPropagation();
    var action = $(this).attr('data-action')
    var feed_id = $(this).attr('data-feed_id')
    var elem = $(this)

    var pdata = { 'action': action, 'feed_id': feed_id };
    //console.log(url)
    performFeedAction(elem, pdata);
});
/** fav/unfav  code : ends **/

function performFeedAction(elem, pdata) {
    $.ajax({
        url: SITE_URL + '/feed-action',
        type: "POST",
        data: pdata,
        dataType: 'JSON',
        beforeSend: function() {

        },
        error: function() {

        },
        success: function() {

        },
        complete: function(data) {
            var obj = JSON.parse(data.responseText);
            if (obj.type == 'success') {
                if (obj.action == 'like') {
                    elem.html('<i class="fas fa-thumbs-up"></i>');
                    elem.attr('data-action', 'unlike')
                } else if (obj.action == 'unlike') {
                    elem.html('<i class="far fa-thumbs-up"></i>');
                    elem.attr('data-action', 'like')
                } else if (obj.action == 'fav') {
                    elem.html('<i class="fas fa-heart"></i>');
                    elem.attr('data-action', 'unfav')
                } else if (obj.action == 'unfav') {
                    elem.html('<i class="far fa-heart"></i>');
                    elem.attr('data-action', 'fav')
                }
            }
        },
    });
}



/*************************confirmation modal start***************************************/
$(document).on("click", ".delete-action", function() {
        var confirmMsg = $(this).data('msg');
        if (confirm(confirmMsg)) {
            return true;
        }
        return false;
    })
    /*************************confirmation modal end***************************************/

/** share feed : starts **/
$(document).on('click', "a[class^='shareBtn']", function(e) {
    var url = $(this).data('remote')
    var share_type = $(this).data('share_type')
    modal = $(this).data("target")
    $(modal).find('.modal-title').html('');
    //console.log(modal)
    $.ajax({
        url: url,
        type: "GET",
        data: {
            'share_type': share_type,
        },
        beforeSend: function() {
            $(modal).find('.modal-body').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
        },
        error: function() {},
        success: function() {
            /** remove multiple backdrop from page */
            if ($(".modal-backdrop").length > 1) {
                console.log('dsadash')
                $(".modal-backdrop").not(':first').remove();
            }
        },
        complete: function(data) {
            var obj = $.parseJSON(data.responseText); //console.log(obj.html)
            $(modal).find('.modal-body').html(obj.html);
            // $('#mainPage__acknowledgeAnExpert').find('.modal-body').html(obj.html);
            // $('#mainPage__acknowledgeAnExpert').modal('show');
            initVueComponent()


        },
    });
});

var vm;

$(document).on('submit', "#shareForm", function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    var model = $('#mainPage__sharetoExpert');
    var postdata = form.serializeArray();

    //console.log( postdata  ); //return false;

    $.ajax({
        type: "POST",
        url: SITE_URL + "/share-feed",
        data: postdata, // serializes the form's elements.
        //data: postdata , // serializes the form's elements.
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
                //$(modal).find('.modal-body').html(obj.html);
                $('#share_to_expert').html('');
                model.find('#content').addClass('hidden');
                model.find('#thanks_up').html(obj.success_html);
                model.find('#thanks_up').removeClass('hidden');

                setTimeout(function() {
                    $('#thanks_up').html('');
                    $('#thanks_up').addClass('hidden');
                    model.find('#thanks_up').html('');
                    model.find('#thanks_up').addClass('hidden');
                    model.find('#content').removeClass('hidden');
                    model.find('.close').click()
                }, 2000);
            } else {
                jQuery.each(obj.keys, function(key, value) {
                    var error_msg = obj.errors[key] //console.log("#"+value)
                    var error_elem = $("#error-" + value);
                    error_elem.show()
                    error_elem.text(error_msg);
                });
            }
        },
    });


});

/** share feed  : ends **/


/**============================== opp like/fav  : start ==========================**/

/** like/dislike opportunity code : starts **/
$(document).on('click', "a[class^='likeOppBtn']", function(e) {
    e.stopPropagation();
    var action = $(this).attr('data-action')
    var oid = $(this).attr('data-oid')
    var elem = $(this)

    var pdata = { 'action': action, 'oid': oid };
    //console.log(url)
    performOppAction(elem, pdata);
});
/** like/dislike opportunity code : ends **/

/** fav/unfav opportunity code : starts **/
$(document).on('click', "a[class^='favOppBtn']", function(e) {
    e.stopPropagation();
    var action = $(this).attr('data-action')
    var oid = $(this).attr('data-oid')
    var elem = $(this)

    var pdata = { 'action': action, 'oid': oid };
    //console.log(url)
    performOppAction(elem, pdata);
});
/** fav/unfav opportunity code : ends **/
function performOppAction(elem, pdata) {
    $.ajax({
        url: SITE_URL + '/opportunity-action',
        type: "POST",
        data: pdata,
        dataType: 'JSON',
        beforeSend: function() {

        },
        error: function() {

        },
        success: function() {

        },
        complete: function(data) {
            var obj = JSON.parse(data.responseText);
            if (obj.type == 'success') {
                if (obj.action == 'like') {
                    elem.html('<i class="fas fa-thumbs-up"></i>');
                    elem.attr('data-action', 'unlike')
                } else if (obj.action == 'unlike') {
                    elem.html('<i class="far fa-thumbs-up"></i>');
                    elem.attr('data-action', 'like')
                } else if (obj.action == 'fav') {
                    elem.html('<i class="fas fa-heart"></i>');
                    elem.attr('data-action', 'unfav')
                } else if (obj.action == 'unfav') {
                    elem.html('<i class="far fa-heart"></i>');
                    elem.attr('data-action', 'fav')
                }
            }
        },
    });
}
/** ========================================opp like/fav  : end ==============================**/
/** ========================================opp apply : start ==============================**/

/** apply code : starts **/
$(document).on('click', "a[id^='applyCardBtn']", function(e) {
        e.stopPropagation(); //console.log('ddddddddddddddddddddd')
        var oppID = $(this).data('oid');
        var elem = $(this);
        var url = $(this).attr('data-href');
        performCardOpportunityAction(elem, url, oppID);
    })
    /** applyBtn code : ends **/
function performCardOpportunityAction(elem, url, oppID) {
    $.ajax({
        url: url,
        type: "GET",
        data: {},
        dataType: 'JSON',
        beforeSend: function() {
            var btnHtml = elem.html()
            if (btnHtml == 'Interested ?') {
                elem.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Processing')
            }
        },
        error: function() {

        },
        success: function() {

        },
        complete: function(data) {
            var obj = JSON.parse(data.responseText); //console.log(obj);
            if (obj.status == 1) {
                if (obj.action == 'APPLY') {
                    $('a[id^="applyCardBtn"]').each(function(index) {
                        if ($(this).data("oid") == oppID) {
                            $(this).html('Withdraw');
                            //$(this).removeClass();
                            $(this).attr('id', 'withdrawCardBtn' + oppID)
                                //$(this).addClass('appliedCardOpp'+oppID);

                        }
                    })
                }
                $('#thumbUpModel').modal('show');
                $('#success_message_thumbupWrapper').html(obj.success_html);
                /*setTimeout(function(){ 
                     $('#thumbUpModel').modal('toggle')
                }, 2000);*/
            }
        },
    });
}





$(document).on('click', "a[id^='withdrawCardBtn']", function(e) {
        e.stopPropagation(); //console.log('ddddddddddddddddddddd')
        var oppID = $(this).data('oid');
        var elem = $(this);
        var url = $(this).attr('data-href');
        url = url.split("/");
        url = url[url.length - 1];
        url = SITE_URL + "/opportunity/withdraw/" + url;
        performCardOpportunityWithdrawAction(elem, url, oppID);
    })
    /** applyBtn code : ends **/
function performCardOpportunityWithdrawAction(elem, url, oppID) {
    $.ajax({
        url: url,
        type: "GET",
        data: {},
        dataType: 'JSON',
        beforeSend: function() {
            var btnHtml = elem.html()
            if (btnHtml == 'Interested ?') {
                elem.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Processing')
            }
        },
        error: function() {

        },
        success: function() {

        },
        complete: function(data) {
            var obj = JSON.parse(data.responseText); //console.log(obj);
            if (obj.status == 1) {
                if (obj.action == 'WITHDRAW') {
                    $('a[id^="withdrawCardBtn"]').each(function(index) {
                        if ($(this).data("oid") == oppID) {
                            $(this).html('Interested ?');
                            //$(this).removeClass();
                            $(this).attr('id', 'applyCardBtn' + oppID)
                                //$(this).addClass('appliedCardOpp'+oppID);

                        }
                    })
                }
                $('#thumbUpModel').modal('show');
                $('#success_message_thumbupWrapper').html(obj.success_html);
                /*setTimeout(function(){ 
                     $('#thumbUpModel').modal('toggle')
                }, 2000);*/
            }
        },
    });
}
/** ========================================opp apply  : end ==============================**/


/**==================== invite-opportunity : starts ====================**/
$(document).on('click', "a[class^='inviteBtn']", function(e) {
    var url = $(this).data('remote')
    modal = $(this).data("target")
    $(modal).find('.modal-title').html('');

    $.ajax({
        url: url,
        type: "GET",
        data: {},
        beforeSend: function() {
            $(modal).find('.modal-body').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
        },
        error: function() {},
        success: function() {
            /** remove multiple backdrop from page */
            if ($(".modal-backdrop").length > 1) {
                $(".modal-backdrop").not(':first').remove();
            }
        },
        complete: function(data) {
            var obj = $.parseJSON(data.responseText); //console.log(obj.html)
            $(modal).find('.modal-body').html(obj.html);
            initInviteVueComponent()
        },
    });
});

$(document).on('submit', "#inviteForm", function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    var model = $('#mainPage__invitetoApply');
    var postdata = form.serializeArray();
    var opp_id = $("input[name='opp_id']").val();

    var checkedUserList = $('#checkedUsers').val().split(","); //console.log(checkedUserList  ); return false;
    $.ajax({
        type: "POST",
        url: SITE_URL + "/opportunity-invite",
        data: postdata, // serializes the form's elements.
        //data: postdata , // serializes the form's elements.
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
                //$(modal).find('.modal-body').html(obj.html);

                model.find('#content').addClass('hidden');
                model.find('#thanks_up').html(obj.success_html);
                model.find('#thanks_up').removeClass('hidden');

                setTimeout(function() {
                    model.find('.close').click();
					$('#thanks_up').html('');
                    $('#thanks_up').addClass('hidden');
                    model.find('#content').removeClass('hidden');
                    $.each(checkedUserList, function(key, value) {
                        //alert( key + ": " + value );
                        //console.log( $('.inviteUserBtn3').html() );
                        //window.top.$('.invitedUserBtn'+value).html('Invited');
                        //window.top.$('.invitedUserBtn'+value).attr('class', 'invitedUserBtn'+opp_id);
                    });
                }, 2000);


            } else {
                jQuery.each(obj.keys, function(key, value) {
                    var error_msg = obj.errors[key] //console.log("#"+value)
                    var error_elem = $("#error-" + value);
                    error_elem.show()
                    error_elem.text(error_msg);
                });
            }
        },
    });


});

/** invite user individually for an opportunity  : starts **/
$(document).on('click', "a[class^='inviteUserBtn']", function(e) {
    e.stopPropagation();
    var action = $(this).attr('data-action')
    var opp_id = $(this).attr('data-opp_id')
    var user_id = $(this).attr('data-user_id')
    var elem = $(this)

    var postdata = { 'action': action, 'opp_id': opp_id, 'user_id': user_id };
    //console.log(url)
    $.ajax({
        type: "POST",
        url: SITE_URL + "/opportunity-invite",
        data: postdata, // serializes the form's elements.
        //data: postdata , // serializes the form's elements.
        beforeSend: function() {},
        error: function() {
            alert('ACK ajax error!')
        },
        success: function() {
            elem.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Processing')
        },
        complete: function(data) {
            var obj = $.parseJSON(data.responseText); // console.log(obj); return false;
            if (obj.type == 'success') { //console.log(obj)
                elem.html('Invited');
                elem.attr('class', 'invitedUserBtn' + opp_id)
            }
            //$('#thumbUpModel').modal('show');
            //$('#success_message_thumbupWrapper').html(obj.success_message);
        },
    });
});
/** invite user individually for an opportunity  : ends **/
/** ==================== invite-opportunity : ends ====================**/
