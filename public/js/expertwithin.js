/** like/dislike code : starts **/
	$(document).on('click',"a[class^='likeBtn']",function(e){
		e.stopPropagation();
		var action = $(this).attr('data-action')
		
		if(action=='like'){
			var url = $('#'+parentClass).attr('data-likeurl');
		}else{
			var url = $('#'+parentClass).attr('data-unlikeurl');
		}
		var page_name = ''
		if ($('#'+parentClass).is('[data-page]')) {
			page_name  = $('#'+parentClass).attr('data-page')
		} 
		//console.log(url)
		performOpportunityAction(elem, url, eventClass, page_type,page_name);
	})
/** like/dislike code : ends **/