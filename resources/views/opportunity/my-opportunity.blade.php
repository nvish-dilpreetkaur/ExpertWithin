@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="{{ URL::asset('js/datatables.min.js') }}"></script>
<link href="{{ URL::asset('css/datatables.css') }}" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<section class="main-body" id="my-opportunities-page">
  <div class="container">
    <div class="opportunity-page-redesign">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="inner-oppor-wrapper">
          <div class="col-md-12 inner-wrapper">
            <div class="row clearfix">
              <div class="col-md-12">
                <h1 class="opportunity-heading">{{ __('My Opportunities') }}</h1>
              </div>
             
            </div>
          </div>
          </div>
           <table class="table display nowrap"  id="my-opp-table" style="width:100%">
              <thead id="for-my-oppor-table">
                <tr class="inner-pages">
                  <th class="">Opportunity</th>
                  <th class="for-sort-filter-four">Manager</th>
                  <th class="for-sort-filter-three">Start</th>
                  <th class="for-sort-filter-three">End</th>
                  <th class="for-sort-filter">Status</th>
                  <!--<th class="">Apply Before</th>
                  <th class="no-search-col">Rewards</th>
                  <th class="no-search-col">Action</th>-->
                </tr>
              </thead>
              <tbody>
                  <!-- table body -->
              </tbody>
			      </table>
    </div>
  </div> 
  </div>
</div>
<script>
    $(document).ready(function () {
    
        var table = $('#my-opp-table').DataTable({
			 scrollX: true,
             processing: true,
             serverSide: true,
             pageLength: "{{ config('kloves.paginateListSize') }}",
             lengthChange: false,
             searching: false,
             bInfo : false,
			 language:{          
			  "processing": '<div class="spinner-border text-secondary" role="status"> <span class="sr-only">Loading...</span></div>',
			 },
             aaSorting: [[0, 'desc']],
             ajax: {
              url: "{{ url('my-opportunities') }}",
              type: 'GET',
             },
             columns: [
                      { data: 'opportunity', name: 'opportunity'},
                      { data: 'opp_manager', name: 'opp_manager' },
                      { data: 'start_date', name: 'start_date' },
                      { data: 'end_date', name: 'end_date' },
                      { data: 'app_status', name: 'app_status' },
                      /*{ data: 'apply_before', name: 'apply_before' },
                      { data: 'rewards', name: 'rewards', orderable: false },
                      { data: 'action', name: 'action', orderable: false},*/
                   ],
             initComplete: function () { 
                  /* this.api().columns().every(function () {
                      var column = this;
                      
                      var input = document.createElement("input");
                      input.className = "search-grid-col12";
                      $(input).appendTo($(column.header()))
                          .on('keyup', function () {
                              column.search($(this).val(), false, false, true).draw();
                      });
                     if(column.header().classList.contains("no-search-col")) {
                       input.disabled = true
                     }
                     
                  }); */
              }, 
            order: []
          });
    
       
      });
</script>
</section>
@endsection