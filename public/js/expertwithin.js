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
