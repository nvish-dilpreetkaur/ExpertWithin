@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="{{ URL::asset('js/datatables.min.js') }}"></script>
<link href="{{ URL::asset('css/datatables.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>


<section class="main-body" id="list-opportunities-page">
  <div class="container">
  <div class="opportunity-page-redesign">
    <div class="row clearfix">
      <div class="col-md-12">
        <div class="inner-oppor-wrapper">
          <div class="col-md-12 inner-wrapper">
            <div class="row clearfix">
              <div class="col-md-7">
                <h1 class="opportunity-heading">{{ __('Managers') }}</h1>
              </div>
              <div class="col-md-5">
              </div>
            </div>
          </div>
			 <table class="table" id="m-manager-table">
						<thead>
							<tr class="inner-pages">
                <th class="">Name</th>
                <th class="">Email</th>
                <th class="">Status</th>
								<th class="no-search-col">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
			</table>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
  
      var table = $('#m-manager-table').DataTable({
           processing: true,
           serverSide: true,
           pageLength: "{{ config('kloves.paginateListSize') }}",
           lengthChange: false,
           bInfo : false,
           ajax: {
            url: "{{ url('managers') }}",
            type: 'GET',
           },
           columns: [
                    { data: 'firstName', name: 'firstName'},
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false},
                 ],
           initComplete: function () { 
                this.api().columns().every(function () {
                    var column = this;
                    //console.log(column.header().textContent)
                    var input = document.createElement("input");
                    input.className = "search-grid-col12";
                    $(input).appendTo($(column.header()))
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                    });
                   if(column.header().classList.contains("no-search-col")) {
                     input.disabled = true
                   }
                   
                }); 
            }, 
          order: []
        });
  
     
    });
    </script>
</section>
@endsection

