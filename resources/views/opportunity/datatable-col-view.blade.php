@php 
$dt_format = config('kloves.DATE_FULL_M_D_Y'); 
@endphp
@if($colName == 'opportunity')
	<td data-search="{{ $oppData->opportunity }}">
		<div class="contnt-box btn">
	     <h5><a href="{{ url('view-opportunity', Crypt::encrypt($oppData->id)) }}">{{ $oppData->opportunity }}</a></h5>
	     <h6> 	@foreach(explode(',', $oppData->focus_areas) as  $focus_area)
			     {{ $loop->first ? '' : ', ' }}
			     {{ @$focus_areas[$focus_area]}}
			 @endforeach
	     </h6>
		</div>
	</td>
@elseif($colName == 'action')
	<td class="text-right action-col">  
		<a class="list-edit-icon" title="{{ __('Edit') }}" href="{{ url('opportunity/edit', Crypt::encrypt($oppData->id)) }}"><i class="fa fa-edit"></i></a>
		@if($oppData->status != 0)
		<a title="{{ __('Cancel') }}" class="delete-action" data-msg="Are you sure to delete this opportunity?" href="{{ url('opportunity/delete', Crypt::encrypt($oppData->id)) }}" data-url=""><i class="fa fa-trash"></i></a>
		@endif 
	</td>
@elseif($colName == 'start_date')
	<td class="text-left"> {{ date("F d,Y", strtotime($oppData->start_date)) }} </td> 

@elseif($colName == 'end_date')
<td class="text-left"> {{ date('F d,Y', strtotime($oppData->end_date)) }} </td>

@elseif($colName == 'apply_before')
<td class="text-left"> {{ date('F d,Y', strtotime($oppData->apply_before)) }} </td> 
@elseif($colName == 'app_status')
<td class="text-left">
	@if( $oppData->app_status==0 )
		{{ 'Approval Pending' }}
	@elseif( $oppData->app_status==1 )
		{{ 'Approved' }}
	@else
		{{ 'Rejected' }}
	@endif
</td> 

@endif
