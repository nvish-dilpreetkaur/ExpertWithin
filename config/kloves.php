<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-users setting
    |--------------------------------------------------------------------------
    */
	'DEFAULT_ORG_ID'                 => 1,
    // Users List Pagination
    'enablePagination'                 => true,
    'paginateListSize'                 => 35,
    'searchResultLimit'                 => 35,

    // Enable Search Users- Uses jQuery Ajax
    'enableSearchUsers'                => true,

    'OPPORTUNITY_LIKE'                  =>  "LIKE",
    'OPPORTUNITY_NOT_LIKE'              =>  "NOT_LIKE",
    'OPPORTUNITY_FAVOURITE'             =>  "FAVOURITE",
    'OPPORTUNITY_NOT_FAVOURITE'         =>  "NOT_FAVOURITE",
    'OPPORTUNITY_APPLY'                  =>  "APPLY",
	
	 // User Bases Constants 
    'ROLE_ADMIN'                		=> 1,
    'ROLE_MANAGER'                		=> 2,
    'ROLE_EXPERT'                      => 3,
    
    'RECORD_STATUS_ACTIVE'              => 1,
    'RECORD_STATUS_INACTIVE'              => 0,
    'RECORD_STATUS_DEACTIVE'            => 2,

	// Texonomy Based Constants 
    'SKILL_AREA'                		=> 1,
    'LOCATION_AREA'                 => 2,
    'FOCUS_AREA'                		=> 3,

    
    // opportunity status
    'OPP_APPLY_NEW'                		 => 0, //draft
    'OPP_APPLY_APPROVED'                 => 1,
    'OPP_APPLY_REJECTED'                 => 2,
    'OPP_APPLY_CANCELLED'                => 3,

    // opportunity apply action status
    'OPP_NEW'                		 => 0,
    'OPP_APPROVED'                 => 1,
    'OPP_DELETE'                 => 2,

    //  comment status
    'COMMENT_ACTIVE'                		 => 1,
    'COMMENT_TYPE_PUBLIC'                => 2,
    'COMMENT_TYPE_PRIVATE'               => 1,

    //Acknoledgement Status 
    'ACK_ACTIVE'                         => 1,
    'ACK_DEACTIVE'                         => 2,

     //Feed_ Status 
     'FEED_ACTIVE'                         => 1,

    //Flag set/unset
    'FLAG_SET'                         => 1,
    'FLAG_UNSET'                       => 0,

     //Feed_Type
     'FEED_TYPE_NEW_OPP'                         => 'new_published_opp',
     'FEED_TYPE_NEW_ACK'                         => 'new_ack_added',
	 
	//Notification Type
      'NOTI_SHARED_OPP'                         => 1,
      'NOTI_SHARED_ACK'                         => 2,
      'NOTI_NEW_ACK_ADDED'                      => 3,
      'NOTI_OPOR_COMPLETED'                     => 4,
      'NOTI_RELATED_OPOR'                       => 5,
      'NOTI_OPOR_INVITES'                       => 6,

      'SEARCH_OPR_LIMIT'        => 12,
];
