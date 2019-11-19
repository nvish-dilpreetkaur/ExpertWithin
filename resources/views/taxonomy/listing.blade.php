@extends('layouts.admin')
@section('content')
@include('common.admin-nav')
<style>
 #taxonomy-page .tab-content > .active{
    padding: 0;
}

#taxonomy-page .taxanomy-redesign{
    margin: 8rem 0;
}

#taxonomy-page .nav-link{
    padding:.5rem 1rem .5rem 1rem;
}

#container-tab ul{

}

#container-tab ul li a.active,
#container-tab ul li a.active:hover{
background-color:#eee;
color:#212324;
border: 1px solid #dedede;
}

#container-tab ul li a:hover{
    color: #FF5D60;
}


/* #admin-tab.nav-item.show .nav-link,
#admin-tab.nav-item .nav-link.active,
#admin-tab.nav-item .nav-link:hover {
    /* color: #fff;
    background-color: #495057;
    border-color: #495057 #495057 #fff;

} */
/*
#taxonomy-page .nav-tabs .nav-link:focus, {
    border-color: #dedede;
    color: #000;
    background-color: #dedede;
} */

#taxonomy-page .modal-content{
    text-align: center;
}

#taxonomy-page  .taxanomy-modal .modal-header{
    padding: 0;
    margin: 0 auto;
    border-bottom: 2px solid #dedede;
    padding-top: .7rem;
}

#taxonomy-form {
    border: none;
}

#taxonomy-page #success .modal-footer{
    justify-content: center;
}

#taxonomy-page .modal-header .close{
    display: none;
}

#taxonomy-page .modal-body input{
    border:2px solid #dedede;
    padding: .4rem;
}


#taxonomy-page .custom-control-input:checked~.custom-control-label::before {
    border-color: #007bff;
    /* background-color: #FF5D60; */
    background-color: #007bff;
}

#taxonomy-page .cmmn-btn.profile-btn {
    padding: .3rem 1rem;
}

#taxonomy-page .common-card-apply-btn {
    padding: .5rem 0;
}
#taxonomy-page table {
    /* width: 69rem !important; */
}

.display-hide{
    display:none;
}

#myTabContent .tab-pane{

}


#taxonomy-page .update-oppr-right-sec{
    margin-right: 0;
}

#taxonomy-page .tab-content a:hover{
    color:#FF5D60;
}
#taxonomy-page  .profile-btns a:hover, .cmmn-btn.profile-btn:hover{
    font-weight:normal;
}
.for-administration-table thead tr th{
    text-align: left;
}

.for-administration-table .custom-control.custom-switch{
    text-align: right;
}


table.dataTable thead:first-child .sorting, 
table.dataTable thead:first-child .sorting_asc, 
table.dataTable thead:first-child .sorting_desc{
    background-position-x: 17rem !important;
}

.for-administration-table .no-search-col{
        text-align:right;
    }

@media only screen and (min-width: 768px){
    .for-administration-table thead tr th,
    .for-administration-table tbody tr td,
    .for-administration-table .custom-control.custom-switch{
        text-align: center;
    }

    .for-administration-table .no-search-col{
        text-align:center;
    }
}



</style>

<!-- <script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="{{ URL::asset('js/datatables.min.js') }}"></script> -->
<!----------new-links-to-test-start------------------->

<!-- <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">  -->
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="{{ URL::asset('js/datatables.min.js') }}"></script>
<link href="{{ URL::asset('css/datatables.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/bootstrap-confirm-delete.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!----------new-links-to-test-end------------------->

<section class="main-body" id="taxonomy-page">
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
                                            <a class="nav-link @php if($flag) echo 'active'; @endphp" id="{{'tax-'.$key}}-tab" data-toggle="tab" href="#{{'tax-'.$key}}" role="tab" aria-controls="{{'tax-'.$key}}" aria-selected="true" data-vocab-id='{{$key}}' data-vocab-name='{{$category}}' >{{$category}}</a>
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
                            <div class="tab-pane vocab-tab fade show @php if($flag) echo 'active'; @endphp" id="{{'tax-'.$index}}" data-vocab-id="{{$index}}" data-vocab-name="{{$vocabulary_names[$index]}}" role="tabpanel" aria-labelledby="{{'tax-'.$index}}-tab">
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
</section>
<!-- Modal -->
<table id="dummy-term-row">
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
</script>
@endsection
