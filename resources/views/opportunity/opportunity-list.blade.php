@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="{{ URL::asset('js/datatables.min.js') }}"></script>
<!----------new-links-to-test-start------------------->


<!-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>  -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<!-- <link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"> -->
<!----------new-links-to-test-end------------------->
<link href="{{ URL::asset('css/datatables.css') }}" rel="stylesheet"/>
<section class="main-body" id="list-opportunities-page">
  <div class="container">
  <div class="opportunity-page-redesign">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="inner-oppor-wrapper">
          <div class="container inner-wrapper">
            <div class="row clearfix">
              <!-- <div class="col-md-6"> -->
              <div class="col">
                <h1 class="opportunity-heading oppor-heading-list">{{ __('Open Opportunities') }}</h1>
              </div>
              <!-- <div class="col-md-6"> -->
              <div class="col">
                  <div class="update-oppr-right-sec">
                  <div class="text-wid-underline effect-underline for-oppor-txt">       
                      <a href="{{ route('create-opportunity') }}" title="">Create Opportunity<i class="fa fa-plus" aria-hidden="true"></i></a>
                   </div>
                   </div>
              </div>
            </div>
          </div>
			 <!-- <table class="table" id="m-opp-table"> -->
         <table id="searchTable" >           
              <tr>
              <td></td>
							</tr>
         </table>
       <table id="m-opp-table" class="table display nowrap" style="width:100%">
						<thead>
							<tr class="inner-pages">
								<th class="">Opportunity</th>
                <th class="for-sort-filter">Start Date</th>
								<th class="for-sort-filter-third-child">End Date</th>
               <!-- <th class="">Apply Before</th>
                <th class="no-search-col">Rewards</th>-->
                <!-- <th class="no-search-col">Action</th> -->
                <th class="disabled-filter no-search-col">Action</th>
              </tr>
						</thead>
						<tbody>
            
            </tbody>
			</table>
      
        
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {

    var table = $('#m-opp-table').DataTable({
        scrollX: true,
        responsive: true,
         processing: true,
         serverSide: true,
         pageLength: "{{ config('kloves.paginateListSize') }}",
         lengthChange: false,
         bInfo : false,
		 language:{          
		  "processing": '<div class="spinner-border text-secondary" role="status"> <span class="sr-only">Loading...</span></div>',
		 },
         ajax: {
          url: "{{ url('opportunities') }}",
          type: 'GET',
         },
         columns: [
                  { data: 'opportunity', name: 'opportunity'},
                  { data: 'start_date', name: 'start_date' },
                  { data: 'end_date', name: 'end_date' },
                 // { data: 'apply_before', name: 'apply_before' },
                //  { data: 'rewards', name: 'rewards', orderable: false },
                  { data: 'action', name: 'action', orderable: false},
               ],
            initComplete: function () { 
              this.api().columns().every(function (value , i) {
                  var column = this;
                 
                  var oldHTML = $("#searchTable tr").html();

                  var input = document.createElement("input");
                  input.className = "search-grid-col12";
                  var td = document.createElement("td");
                  if(!column.header().classList.contains("no-search-col")) {
                    $(input).appendTo(td).on('keyup', function () {
                      column.search($(this).val(), false, false, true).draw();
                    });
                 }
                 
                  $(td).appendTo($("#searchTable tr"));
              });
              
                 /* var column = this;
                  //console.log(column.header().textContent)
                  var input = document.createElement("input");
                  input.className = "search-grid-col12";
                  $(input).appendTo($(column.header()))
                      .on('keyup', function () {
                          column.search($(this).val(), false, false, true).draw();
                  });
                 if(column.header().classList.contains("no-search-col")) {
                   //input.disabled = true
                   input.style.display = 'none'
                 }
                 */
          }, 
          order: []
      });

      // new $.fn.dataTable.FixedHeader( table );
  });
  </script>
</section>

@endsection

	