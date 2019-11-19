@if($colName == 'action')
     <td class="text-right">  
		<?php /* <a title="{{ __('Edit') }}" class="" href="{{ url('profile', Crypt::encrypt($users->id)) }}"><i class="fa fa-edit"></i></a>
		&nbsp; &nbsp;
		@if($users->role_status == 0)
		<a class="list-edit-icon" title="{{ __('Mark As Unapproved') }}" href="{{ url('role_action/approve', Crypt::encrypt($users->roleID)) }}"><i class="fa fa-check"></i></a>
		@else 
		<a title="{{ __('Cancel') }}" class="delete-action" data-msg="Are you sure to close this opportunity?" href="{{ url('role_action/not_approve', Crypt::encrypt($users->roleID)) }}" data-url=""><i class="fa fa-trash"></i></a>
		@endif  */ ?>
		<a title="{{ __('Delete') }}" class="delete-action" data-msg="Are you sure to delete?" href="{{ url('role_action/remove', Crypt::encrypt($users->id)) }}" data-url=""><i class="fa fa-trash"></i></a>
    </td>
@elseif($colName == 'status')
	<td>
		@if($users->role_status == '1')
		Approved
		@else
		Pending
		@endif
	</td>
@elseif($colName == 'is_manager')
	<td>
		@if($users->cur_active_role == $users->requested_role)
			{{ ($users->cur_active_role==config('kloves.ROLE_MANAGER')) ? 'Yes' : 'No' }}
		@elseif($users->cur_active_role != $users->requested_role)
			@if($users->requested_role==config('kloves.ROLE_MANAGER'))
				<a href="javascript:void(0)" class="open-approval-modal" data-user_id="{{ $users->id }}" data-role="{{ $users->requested_role }}">Waiting for approval</a>
			@else
				{{ '-' }}
			@endif
		@endif
	</td>
@endif
