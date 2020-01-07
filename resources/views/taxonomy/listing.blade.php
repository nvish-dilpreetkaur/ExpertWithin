@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/old_style.css') }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!----------new-links-to-test-end------------------->
<div class="main-contnt-body" id="taxonomy-page">
    <div class="container">
        <div class="favorite-page-redesign taxanomy-redesign">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="inner-oppor-wrapper">
                        <div class="col-md-12 inner-wrapper">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h1 class="opportunity-heading">{{ __('Administration') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row clearfix">
                                <div class="col-md-6" id="container-tab">
                                    <ul class="nav nav-tabs taxanomy-tabs" id="myTab" role="tablist">
                                        @php
                                            $flag = true; $initial_category = $initial_id = "";
                                        @endphp

                                        @foreach($vocabulary_names as $key=>$category)
                                        <li class="nav-item">
                                            <a class="nav-link {{ ($flag) ? 'active' : '' }} " id="{{'tax-'.$key}}-tab" data-toggle="tab" href="{{'#tax-'.$key}}" role="tab" aria-controls="{{'tax-'.$key}}" aria-selected="true" data-vocab-id='{{$key}}' data-vocab-name='{{$category}}' >{{$category}}</a>
                                        </li>
                                            @php
                                                if($flag) {
                                                    $initial_category = $category;
                                                    $initial_id = $key;
                                                }
                                                $flag = false;
                                            @endphp
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="offset-md-3 col-md-2">
                                    <div class="update-oppr-right-sec">
                                        <div class="text-wid-underline effect-underline">
                                            <a href="javascript:void(0);" class="open-modal add-item" title="" data-vocab-id='{{$initial_id}}'>
                                                        <span>Add {{$initial_category}}</span>&nbsp;
                                                        <i class="fa fa-plus" aria-hidden="true" ></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="myTabContent">
                            @php $flag = true; @endphp
                            @foreach($taxonomy as $index=>$item)
                            <div class="tab-pane vocab-tab fade show {{ ($flag) ? 'active' : '' }}" id="{{'tax-'.$index}}" data-vocab-id="{{$index}}" data-vocab-name="{{$vocabulary_names[$index]}}" role="tabpanel" aria-labelledby="{{'tax-'.$index}}-tab">
                                <table class="table display nowrap for-administration-table" id="my-opp-table-{{$index}}" style="width:100%">
                                    <thead>
                                        <tr class="inner-pages">
                                            <th class="">Name</th>
                                            <th class="no-search-col statusCol">Status</th>
                                            <th class="display-hide">Updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($item))
                                            @foreach($item as $term)
                                            @php $checked = ($term["status"]==1)?"checked":"" @endphp
                                            <tr class="term-row">
                                                <td class="term-name">
                                                    <a href="javascript:void(0)" class="open-modal" data-item-id='{{$term["tid"]}}'>
                                                        {{$term["name"]}}
                                                    </a>
                                                </td>
                                                <td class="">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="term-status custom-control-input" id="customSwitch{{$term['tid']}}" data-item-id='{{$term["tid"]}}' {{$checked}}>
                                                        <label class="custom-control-label" for="customSwitch{{$term['tid']}}"></label>
                                                    </div>
                                                </td>
                                                <td class="display-hide">
                                                    {{$term["updated_at"]}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @php $flag = false; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal taxanomy-modal" id="success" tabindex="-1" role="dialog" aria-labelledby="taxonomyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxonomyModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action='' id="taxonomy-form">
                    <div class="modal-body">
                        <div class="form-group clearfix">
                            <!-- label>Add/Edit Term</label-->
                            <input type="text" id="item-name" placeholder="Enter Name" class="mt-3 form-control" />
                            <span class="input-error-msg" role="alert">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmmn-btn save-btn profile-btn" data-dismiss="modal">Close</button>
                        <input type="submit" class="cmmn-btn save-btn profile-btn" value="Save changes">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<table id="dummy-term-row"  class="d-none">
    <tr class="term-row">
        <td class="term-name w-80 text-left">
            <a href="javascript:void(0)" class="open-modal" data-item-id=''>
            </a>
        </td>
        <td class="w-10 text-left">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="term-status custom-control-input"  id="" data-item-id='' checked="checked" >
                <label class="custom-control-label" for=""></label>
            </div>
        </td>
        <td class="display-hide">
        </td>
    </tr>
</table>

<!-- data-toggle="modal" data-target="#success" -->
<script type="text/javascript">

    $(document).ready(function () {
        @php $count =0; @endphp
        @foreach($taxonomy as $index=>$value)

            $('#my-opp-table-{{$index}}').DataTable({
                 scrollX: true,
                 responsive: true,
                 processing: true,
                  language:{
                  "processing": '<div class="spinner-border text-secondary" role="status"> <span class="sr-only">Loading...</span></div>',
                  },
                 pageLength: {{ config('kloves.paginateListSize')}},
                 lengthChange: false,
                 bInfo : false,
                 columns: [
                      { data: 'name', name: 'name'},
                      { data: 'status', name: 'status', orderable: false },
                      { data: 'update_at', name: 'update_at', orderable: false},
                 ],
                order: [[2,"desc"]],
            });
        @endforeach
        
      });



/*************************************Taxonomy*************************************/
var taxonomy_item_id=0, vocab_id=0,tax_item="", vocab_tab = "",vocab_table="";

$(document).ready(function(){
	$("#taxonomy-form").submit(function(ev){ 
		ev.preventDefault();

		var item_name = $("#item-name").val();
		var form  = $(this).attr("id");

		$.ajax({
				url: SITE_URL+"/taxonomy",
				type: "POST",
				data: { "taxonomy_item_id":taxonomy_item_id,"item-name": item_name, "vocab_id": vocab_id },
				dataType: 'JSON',
				   beforeSend: function(){
				},error: function(data){
					validation_errors(data,form)
				}, success: function(){
				}, complete: function( data ){
					var obj = $.parseJSON(data.responseText); 
					
					if(obj.type=='success'){
						if(isNaN(taxonomy_item_id)){
							var new_term_row = $("#dummy-term-row tr").clone();
							new_term_row.find(".term-name>a").text(item_name)
							new_term_row.find(".term-name>a").attr("data-item-id", obj.id);

							new_term_row.find(".term-status").attr("data-item-id", obj.id);
							new_term_row.find(".term-status").attr("id", "customSwitch"+obj.id);

							new_term_row.find(".custom-control-label")	.attr("for", "customSwitch"+obj.id);
							

							var date = moment(obj.date).format("YYYY-MM-DD H:mm:ss"); //changed back from ISO format
							new_term_row.find("td:last").text(date);

							var t = vocab_table.closest("table").DataTable();
					        t.row.add(new_term_row).draw(true);
					        t.order([2, 'desc']).draw();					       
						} else {		
							tax_item.closest(".term-row").find("td.term-name>a").text(item_name);
						}
						
						$("#success").modal("hide");
						$("#ajaxsuccess .modal-body p.success-text").text(obj.html);
						$("#ajaxsuccess").modal("show");
					} 
				}
		});
	});
});

$(document).on("click", ".term-status", function(){
	
	var status = $(this).prop("checked");
	var vocab_id = $(this).closest(".vocab-tab").data("vocab-id");

	taxonomy_item_id  = parseInt($(this).data("item-id"));

	$.ajax({
			url: SITE_URL+"/taxonomy/status",
			type: "POST",
			data: { "taxonomy_item_id":taxonomy_item_id,"status":status,"vocab_id":vocab_id},
			dataType: 'JSON',
			   beforeSend: function(){
				
			}, error: function(){	
				alert('Applicant fetch ajax error!')
			}, success: function(){
				
			}, complete: function( data ){

				var obj = $.parseJSON(data.responseText); 
				
				if(obj.type=='success'){
					$("#ajaxsuccess .modal-body p.success-text").text(obj.html);
					$("#ajaxsuccess").modal("show");
			}
		}
	});
})

$(document).on("click",".open-modal", function(){

		form = "taxonomy-form";

		if($(this).hasClass("add-item")){
			v_id = $(this).data("vocab-id");
			tax_item = $("#my-opp-table-"+v_id);
		} else {
			tax_item  = $(this);
		}
		
		vocab_tab = tax_item.closest(".vocab-tab");
		vocab_table = tax_item.closest(".vocab-tab").find("table tbody");

		vocab_id = parseInt(vocab_tab.data("vocab-id"));
		var vocab_name = vocab_tab.data("vocab-name");
		taxonomy_item_id = parseInt(tax_item.data("item-id"));

		var tax_name  = tax_item.closest(".term-row").find("td.term-name>a").text().trim();

		if(tax_name!=''){
			$("#item-name").val(tax_name);	
			$("#taxonomyModalLabel").text("Edit "+vocab_name);			
		} else {
			$("#taxonomyModalLabel").text("Add "+vocab_name);
			$("#item-name").val('');	
		}
		
		var all = ["item-name"];
		var valid = [];
		clear_validation_errors(all,valid);
		
		$("#success").modal("show");
});

$(document).ready(function(){
	$("#myTab.nav-tabs a").on("shown.bs.tab", function(){		
		$($.fn.dataTable.tables(true)).DataTable()
			.columns.adjust();
		var button = $(this).closest(".row").find("a.open-modal");

		button.data("vocab-id",$(this).data("vocab-id"));
		button.find("span").text("Add "+$(this).data("vocab-name"));
	})
})



function clear_validation_errors(all, valid){

	var diff = $(all).not(valid).get();
	
	$.each( diff, function(key, value){
	 		$("#"+value).removeClass("is-invalid");
            $("#"+value).closest(".form-group").find(".input-error-msg").text("");
	});
}

function validation_errors(data, form){

	var obj = $.parseJSON(data.responseText); 

	var all = [];
	$("#"+form+" .is-invalid").each(function(){
			all.push($(this).attr("id"));
	});

	if(obj.hasOwnProperty('errors')){

		var valid = [];

        $.each( obj.errors, function( key, value ) {

     		  valid.push(key);
              $("#"+key).addClass("is-invalid");
              $("#"+key).closest(".form-group").find(".input-error-msg").text(value[0]);
     	});
        
        clear_validation_errors(all, valid);

    } else {
    	alert('Applicant fetch ajax error!');
    }
}
/*************************************Taxonomy*************************************/


</script>
@endsection
