<div class="row">
	<div id="temp-model-wrapper"></div>
	<div class="search-container-outer">
		<div class="search-slide-down-container search__scroll-container">
				<div class="search-close-button"><i class="fas fa-times search__popup-close"></i></div>
	
				<div class="col-md-12">
					<div class="">
				<div class="search-drawer-content">
						<div class="form-group">
						<form>					
							<div class="search-drawer-input">
								<input type="text" id="search__data-field" class="form-control">
								<i class="fas fa-times" id="search__clear-data-field" style="display:none;"></i>
							</div> 
							<div class="search-drawer-content-btn">
								<button type="button" id="search__btn" class="search-drawer-btn">Search</button>
							</div>
						</form>
						</div>
						<div class="search-drawer-content-pills">
						<ul id="search__focus-area-list"></ul>
						</div>
						<div class="search-drawer-cards">						 
						 
								<div class="container">
									<p>Search results</p>
										<div class="row clearfix" id="search__opportunity-content"></div>
									</div>
									<!---------->
						</div><!-----search-drawer-cards-ENDS-->
		
				</div>
				</div>
				</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var selectedFocusArea = [];
	var searchText = "";
	var page = 1;
	var hasMoreData = true;

	function makeSearchCall() {
		page = 1;
		searchText = document.getElementById("search__data-field").value;
		if(searchText.length > 0) {
			$("#search__clear-data-field").show();
		} else {
			$("#search__clear-data-field").hide();
		}
		$.ajax({
			type: "POST",
			url: SITE_URL+"/search",
			data: { "search_text": searchText, "focus_area": selectedFocusArea, "page": page },
			success: function(data){
				if(data.status==true) {
					page++;
					hasMoreData = data.hasMoreData;
					$("#search__opportunity-content").html(data.html);
				}
			}
		});
	}

	$.ajax({
		type: "GET",
		url: SITE_URL+"/focus-areas",
		success: function(data){
			if(data.status==true) {
				var focusAreaHtml = "";
				$.each(data.response.focusArea, function( index, value ) {
					focusAreaHtml += '<li class="search__focus-area" data-fid="'+value.tid+'">'+value.name+'</li>';
				});
				$("#search__focus-area-list").html(focusAreaHtml);
			}
		}
	});

	makeSearchCall();

	$(document).on("click", "#search__btn", function() {
		makeSearchCall();
	});

	$(document).on('keyup change','#search__data-field', function() {
		makeSearchCall();
	});

	$('#search__data-field').keypress(function(e){
      if(e.which === 13) {
		e.preventDefault();
	  }
   });


	$(document).on("click", "#search__clear-data-field", function() {
		document.getElementById("search__data-field").value = "";
		makeSearchCall();
	});

	$(document).on("click", ".search__focus-area", function() {
		page = 1;
		let fid = $(this).data('fid');
		if($(this).hasClass("active")) {
			// Remove From focus Area list
			$(this).removeClass("active");
			selectedFocusArea.splice( $.inArray(fid, selectedFocusArea), 1 );
		} else {
			// Add to focus Area List
			$(this).addClass("active");
			selectedFocusArea.push(fid);
		}

		makeSearchCall();
	});

	var isLoading=false;
	$('.search__scroll-container').on('scroll', function() {
		if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
			if(hasMoreData==true && isLoading==false) {
				isLoading = true;
				$.ajax({
					type: "POST",
					url: SITE_URL+"/search",
					data: { "search_text": searchText, "focus_area": selectedFocusArea, "page": page },
					success: function(data){
						if(data.status==true) {
							page++;
							hasMoreData = data.hasMoreData;
							$("#search__opportunity-content").append(data.html);
							isLoading = false;
						}
					}
				});
			} else {
				console.log("No More Data To Show");
			}
		}
	});

	$(document).on("click", ".search__popup-close", function() {
		window.location.href = "<?=route('list-opportunity')?>";

		// $("#search__opportunity-content").html("");
		// page = 1;
		// hasMoreData = true;
		// searchText = "";
		// document.getElementById("search__data-field").value = "";
		// selectedFocusArea = [];
		// $(".search__focus-area").removeClass("active");
		
		// makeSearchCall();
	});
});
</script>