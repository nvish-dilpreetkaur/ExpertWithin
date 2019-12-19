@extends('layouts.app')
@section('content')  
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/old_style.css') }}">
<!-- <link rel="stylesheet" href="{{ URL::asset('css/user-style.css') }}"> -->
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<section class="main-contnt-body" id="list-opportunities-page">
  <div class="container">
  <div class="opportunity-page-redesign user-mgmt">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="inner-oppor-wrapper">
          <div class="col-md-12 inner-wrapper">
            <div class="row clearfix">
              <div class="col-md-7">
                <h1 class="opportunity-heading">{{ __('User Management') }}</h1>
              </div>
              <!--<div class="col-md-5">
                <a href="{{ url('add-user') }}" ><i class="fa fa-plus"></i></a>
              </div>-->
            </div>
          </div>
          <table id="u-searchTable" >           
            <tr>
            <td></td>
            </tr>
       </table>
			 <table id="m-user-table" class="table display nowrap" style="width:100%">
						<thead>
							<tr class="inner-pages">
                <th class="for-first-filter">Name</th>
                <th class="for-secnd-filter">Email</th>
                <th class="for-thrd-filter">Is Manager</th>
                <th class="for-action-on-usr no-search-col">Action</th>
							</tr>
						</thead>
						<tbody>
					
						</tbody>
			</table>
         
      </div>
    </div>
  </div>
</div>

    <!-- approval model : start -->
    <div class="modal action-modal" id="user_approval_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popModalLabel">Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ url('hr-action') }}" id="action-form"> 
                    <div class="modal-body">
						<div class="form-group clearfix">
						  <div class="form-check-inline">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" value="approve" name="hr_action">Approve
                            </label>
                          </div>
						  <div class="form-check-inline">
							<label class="form-check-label">
							  <input type="radio" class="form-check-input" value="not_approve" name="hr_action" id="hr_action" >Reject
							</label>
							@csrf
						  </div>
						   <div class="form-check-inline">
						  <span class="input-error-msg" role="alert"></span>
						  </div>
						</div>
						  <input type="hidden" name="user_id" id="user_id" value="">
						  <input type="hidden" name="role" id="role" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmmn-btn save-btn profile-btn" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="cmmn-btn save-btn profile-btn" value="Save changes">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- approval model : end -->

    
<script>
    $(document).ready(function () {
    
        var table = $('#m-user-table').DataTable({
            scrollX: true,
             processing: true,
             serverSide: true,
             pageLength: "{{ config('kloves.paginateListSize') }}",
             lengthChange: false,
             bInfo : false,
             language:{          
              "processing": '<div class="spinner-border text-secondary" role="status"> <span class="sr-only">Loading...</span></div>',
              },
             ajax: {
              url: "{{ url('users') }}",
              type: 'GET',
             },
             columns: [
                      { data: 'firstName', name: 'firstName'},
                      { data: 'email', name: 'email' },
                      { data: 'is_manager', name: 'is_manager' },
                      { data: 'action', name: 'action', orderable: false},
                   ],
             initComplete: function () { 
                  /*   this.api().columns().every(function (value , i) {
                      var column = this;
                    
                      var oldHTML = $("#u-searchTable tr").html();

                      var input = document.createElement("input");
                      input.className = "search-grid-col12";
                      var td = document.createElement("td");
                      if(!column.header().classList.contains("no-search-col")) {
                        $(input).appendTo(td).on('keyup', function () {
                          column.search($(this).val(), false, false, true).draw();
                        });
                    }
                    
                      $(td).appendTo($("#u-searchTable tr"));
                     
                  }); */
              }, 
            order: [0, 'asc']
          });
    
       
      });
  
      $(document).on("click",".open-approval-modal", function(){
		  var user_id = $(this).data("user_id");
		  var role = $(this).data("role");
		  $('#user_id').val(user_id)
		  $('#role').val(role)
          $("#user_approval_modal").modal("show");
      });
	  
		$(document).ready(function(){
			$("#action-form").submit(function(ev){ 
				//ev.preventDefault();
				if(!custom_validate()){
					return false
				}
				return true
				/* var form  = "action-form";

				$.ajax({
						url: SITE_URL+"/hr-action",
						type: "POST",
						data:{ "formData" : $("#action-form").serialize() , "_token": "{{ csrf_token() }}",},
						dataType: 'JSON',
						beforeSend: function(){
							
						},error: function(data){
							validation_errors(data,form)
						}, success: function(){
							
						}, complete: function( data ){
							var obj = $.parseJSON(data.responseText); 
							
							if(obj.type=='success'){
					
								alert(obj.html);
								$("#user_approval_modal").modal("hide");
							} 
						}
				}); */
			});
		});
		
		function custom_validate(){
			if($('input[name=hr_action]:checked').length == 0){
				$("input[name=hr_action]").closest(".form-group").find(".input-error-msg").text('No action selected.');
				return false;
			} 
			return true
		} 
      </script>
</section>
@endsection

