@if($notification_row['type_of_notification'] == config('kloves.NOTI_SHARED_OPP') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> has shared an opportunity <span class="blue-txt-clr">{{ char_trim($notification_row['opportunity']['opportunity'],40) }} </span> with you.</li>
@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_SHARED_ACK') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> has shared <span class="blue-txt-clr">1 new acknowledgement </span> with you.</li>
@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_NEW_ACK_ADDED') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> acknowledged you.</li>
@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_OPOR_INVITES') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> has invited you to apply on <span class="blue-txt-clr">{{ char_trim($notification_row['opportunity']['opportunity'],40) }}</span> opportunity.</li>
@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_OPOR_COMPLETED') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> has completed your opportunity. </li>
@endif
