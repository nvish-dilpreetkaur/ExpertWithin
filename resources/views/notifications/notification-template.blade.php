@if($notification_row['type_of_notification'] == config('kloves.NOTI_SHARED_OPP') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> has shared an opportunity <span class="blue-txt-clr">{{ char_trim($notification_row['opportunity']['opportunity'],40) }} </span> with you.</li>
@elseif($notification_row['type_of_notification'] == config('kloves.NOTI_SHARED_ACK') )
<li><span class="blue-txt-clr">{{ $notification_row['sender']['firstName'] }}</span> has shared <span class="blue-txt-clr">1 new acknowledgement </span> with you.</li>
@endif
<!--<li>You have <span class="blue-txt-clr">1 Open Opportunity</span> in draft.</li>
      <li><span class="blue-txt-clr">Acknowledge </span> Mock Choi for completing an opp</li>
<li><span class="blue-txt-clr">Natasha Vargas</span> acknowledged you.</li>
<li>There are <span class="blue-txt-clr">2 new opportunities </span> related to your skill sets</li>-->