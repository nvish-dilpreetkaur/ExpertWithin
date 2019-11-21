<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-users setting
    |--------------------------------------------------------------------------
    */

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
    'RECORD_STATUS_DEACTIVE'            => 2,

	// Texonomy Based Constants 
    'SKILL_AREA'                		=> 1,
    'LOCATION_AREA'                 => 2,
    'FOCUS_AREA'                		=> 3,

    'HOME_CARD_CLASSES'                 => array( 
		0 => ['lite-blue-border','open-book-blue.svg', 'lite-blue'],
		1 => ['nlcolorclass','open-book-purple.svg', 'nlcolorclass'],
		2 => ['navy-clr-bottom','open-book-navy.svg', 'navy-clr'],
		3 => ['mint-clr-bottom','open-book-mint.svg', 'mint-clr'],
		4 => ['yellow-clr-bottom','open-book-yellow.svg', 'yellow-clr'],
		5 => ['green-clr-bottom','open-book-green.svg', 'green-clr']
    ),
    
    // opportunity status
    'OPP_APPLY_NEW'                		 => 0, //draft
    'OPP_APPLY_APPROVED'                 => 1,
    'OPP_APPLY_REJECTED'                 => 2,

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
];
