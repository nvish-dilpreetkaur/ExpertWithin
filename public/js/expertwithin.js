/** like/dislike code : starts **/
	$(document).on('click',"a[class^='likeBtn']",function(e){
		e.stopPropagation();
		var action = $(this).attr('data-action')
		var feed_id = $(this).attr('data-feed_id')
		var elem = $(this)
		
		var pdata = {'action' : action, 'feed_id': feed_id};
		//console.log(url)
		performFeedAction(elem,pdata);
	});
/** like/dislike code : ends **/

/** fav/unfav code : starts **/
$(document).on('click',"a[class^='favBtn']",function(e){
	e.stopPropagation();
	var action = $(this).attr('data-action')
	var feed_id = $(this).attr('data-feed_id')
	var elem = $(this)
	
	var pdata = {'action' : action, 'feed_id': feed_id};
	//console.log(url)
	performFeedAction(elem,pdata);
});
/** fav/unfav  code : ends **/

	function performFeedAction(elem,pdata){
		$.ajax({
			url: SITE_URL+'/feed-action',
			type: "POST",
			data:pdata,
			dataType: 'JSON',
			beforeSend: function(){

			},error: function(){
				
			},success: function(){
				
			},complete: function( data ){
				var obj = JSON.parse( data.responseText ); 
				if(obj.type=='success'){
					if(obj.action=='like'){
						elem.html('<i class="fas fa-thumbs-up"></i>');
						elem.attr('data-action','unlike')
					}else if(obj.action=='unlike'){
						elem.html('<i class="far fa-thumbs-up"></i>');
						elem.attr('data-action','like')
					}else if(obj.action=='fav'){
						elem.html('<i class="fas fa-heart"></i>');
						elem.attr('data-action','unfav')
					}else if(obj.action=='unfav'){
						elem.html('<i class="far fa-heart"></i>');
						elem.attr('data-action','fav')
					}
				}
			},
		});
	}


	
/*************************confirmation modal start***************************************/
$(document).on("click", ".delete-action", function(){
	var confirmMsg = $(this).data('msg'); 
	if(confirm(confirmMsg)){
		return true;
	}
	return false;
})
/*************************confirmation modal end***************************************/

/** share feed : starts **/
$(document).on('click',"a[class^='shareBtn']",function(e){  
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
            error: function() {
            },
            success: function() {
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
$(document).on('submit',"#shareForm",function(e){
	e.preventDefault(); // avoid to execute the actual submit of the form.
	var form = $(this);
	var model = $('#mainPage__sharetoExpert');
	var postdata = form.serializeArray();

	//console.log( postdata  ); //return false;
	
	$.ajax({
		type: "POST",
		url: SITE_URL+"/share-feed",
		data: postdata ,// serializes the form's elements.
		//data: postdata , // serializes the form's elements.
		beforeSend: function(){
		},error: function(){
			alert('ACK ajax error!')
		},success: function(){
			$('.invalid-feedback').hide()
		},complete: function( data ){
			var obj = $.parseJSON( data.responseText );  
			if(obj.type=='success'){ //console.log(obj)
				//$(modal).find('.modal-body').html(obj.html);
				model.find('#content').addClass('hidden');
				model.find('#thanks_up').html(obj.success_html);
				model.find('#thanks_up').removeClass('hidden');
				setTimeout(function(){  
					model.find('.close').click()
			     }, 2000);
			}else{
				jQuery.each(obj.keys, function(key, value){
					var error_msg = obj.errors[key] //console.log("#"+value)
					var error_elem =  $("#error-"+value);
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
$(document).on('click',"a[class^='likeOppBtn']",function(e){
	e.stopPropagation();
	var action = $(this).attr('data-action')
	var oid = $(this).attr('data-oid')
	var elem = $(this)
	
	var pdata = { 'action' : action, 'oid': oid };
	//console.log(url)
	performOppAction(elem,pdata);
}); 
/** like/dislike opportunity code : ends **/

/** fav/unfav opportunity code : starts **/
$(document).on('click',"a[class^='favOppBtn']",function(e){
	e.stopPropagation();
	var action = $(this).attr('data-action')
	var oid = $(this).attr('data-oid')
	var elem = $(this)
	
	var pdata = { 'action' : action, 'oid': oid };
	//console.log(url)
	performOppAction(elem,pdata);
}); 
/** fav/unfav opportunity code : ends **/
function performOppAction(elem,pdata){
	$.ajax({
		url: SITE_URL+'/opportunity-action',
		type: "POST",
		data:pdata,
		dataType: 'JSON',
		beforeSend: function(){

		},error: function(){
			
		},success: function(){
			
		},complete: function( data ){
			var obj = JSON.parse( data.responseText ); 
			if(obj.type=='success'){
				if(obj.action=='like'){
					elem.html('<i class="fas fa-thumbs-up"></i>');
					elem.attr('data-action','unlike')
				}else if(obj.action=='unlike'){
					elem.html('<i class="far fa-thumbs-up"></i>');
					elem.attr('data-action','like')
				}else if(obj.action=='fav'){
					elem.html('<i class="fas fa-heart"></i>');
					elem.attr('data-action','unfav')
				}else if(obj.action=='unfav'){
					elem.html('<i class="far fa-heart"></i>');
					elem.attr('data-action','fav')
				}
			}
		},
	});
}
/** ========================================opp like/fav  : end ==============================**/