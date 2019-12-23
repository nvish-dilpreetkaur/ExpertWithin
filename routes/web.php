<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

//linkedin routes
Route::get('linkedin', function () {
	return view('loginlinkedin');
});
Route::get('/redirect', 'SocialAuthLinkedinController@redirect');
Route::get('/callback', 'SocialAuthLinkedinController@callback');

Route::group( ['middleware' => ['auth']], function() {
	Route::get('/', 'IndexController@index')->name('home');
	Route::post('/', 'IndexController@index')->name('home');
	Route::post('/acknowledge', 'AcknowledgementController@acknowledge')->name('acknowledge');
	Route::get('/ack-form', 'AcknowledgementController@ackForm')->name('ack-form');
	
	Route::get('/profile', 'UserController@show')->name('profile');
	Route::get('/profile/{id}', 'UserController@show')->name('user-profile');
	Route::post('/update', 'UserController@update')->name('update');
	Route::post('/update/{id}', 'UserController@update')->name('update-profile');

	Route::post('/sort-widget', 'IndexController@sortWidget')->name('sort-widget');
	Route::post('/feed-action', 'FeedController@feedAction')->name('feed-action');
	Route::get('/share-feed/{id}', 'FeedController@feedShare')->name('share-feed');
	Route::post('/share-feed', 'FeedController@postFeed')->name('share-feed');
	
	Route::get('view-opportunity/{id}','OpportunityController@view')->name('view-opportunity');
	Route::any('add-opportunity','OpportunityController@addOpportunity')->name('add-opportunity');
	Route::any('create-opportunity/{oid}','OpportunityController@createOpportunity')->name('create-opportunity');
	Route::any('store-opportunity','OpportunityController@storeOpportunity')->name('store-opportunity');
	Route::any('store-draft-opportunity','OpportunityController@storeDraftOpportunity')->name('store-draft-opportunity');
	Route::get('draft-opportunity/{oid}','OpportunityController@draftOpportunity')->name('draft-opportunity');
	Route::get('cancel-opportunity/{oid}','OpportunityController@cancelOpportunity')->name('cancel-opportunity');
	Route::post('approve-opportunity','OpportunityController@approveOpportunity')->name('approve-opportunity');
	Route::post('disapprove-opportunity','OpportunityController@disapproveOpportunity')->name('disapprove-opportunity');
	Route::post('dismiss-opportunity','OpportunityController@dismissOpportunity')->name('dismiss-opportunity');
	Route::any('published-opportunity/{oid}','OpportunityController@publishedOpportunity')->name('published-opportunity');
	
	Route::post('opportunity-action', 'OpportunityUserController@actionOpportunityUser')->name('opportunity-action');
	Route::get('opportunity/{action}/{id}', 'OpportunityUserController@applyOpportunity')->name('opportunity-apply');
	Route::get('favorites', 'OpportunityUserController@favoritesOpportunity')->name('favorites');

	Route::post('user_interests','UserController@save_user_interests')->name('user_interests');
	Route::post('save_user_profile','UserController@save_user_profile')->name('save_user_profile');
	
	//admin controller
	Route::get('users','AdminController@list_users')->name('users');
	Route::post('hr-action','AdminController@hrAction')->name('hr-action');
	Route::get('role_action/{action}/{id}','AdminController@roleAction')->name('role_action');

	Route::get('taxonomy', 'TaxonomyController@index')->name('taxonomy-list');
	Route::post('taxonomy', 'TaxonomyController@update')->name('taxonomy-update');
	Route::post('taxonomy/status', 'TaxonomyController@status')->name('taxonomy-delete');

	/*
	Route::get('/home', 'HomeController@index')->name('home');
	Route::any('search', 'IndexController@searchOpportunity')->name('search');
	
	
	Route::get('/add-user', 'UserController@index')->name('add-user');
	Route::post('/create-user', 'UserController@create')->name('create-user');
	Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
	//Opportunities
	Route::get('opportunities','OpportunityController@index')->name('opportunities');
	Route::get('create-opportunity', 'OpportunityController@formOpportunity')->name('create-opportunity');
	Route::get('opportunity/edit/{id}', 'OpportunityController@formOpportunity')->name('edit-opportunity');
	Route::post('new-opportunity', 'OpportunityController@createOpportunity')->name('new-opportunity');
	Route::post('update-opportunity/{id}', 'OpportunityController@updateOpportunity')->name('update-opportunity');
	Route::get('opportunity/delete/{id}', 'OpportunityController@deleteOpportunity')->name('delete-opportunity');
	Route::get('my-opportunities', 'OpportunityUserController@myOpportunity')->name('my-opportunities');
	
	Route::get('view-opportunity/{id}','OpportunityController@view')->name('view-opportunity');
	Route::get('/opp-applicants/{id}','OpportunityController@applicants')->name('opp-applicants');
	Route::get('/opp-comment-list/{id}','OpportunityController@getOppPublicComments')->name('opp-comment-list');
	Route::get('/opp-user-conversation','OpportunityController@getOppConversation')->name('opp-user-conversation');

	//Opportunity apply/like/favourite
	Route::get('opportunity/{action}/{id}', 'OpportunityUserController@actionOpportunityUser')->name('opportunity-action');
	Route::any('opp-action', 'OpportunityUserController@opportunityAction')->name('opp-action');
	Route::any('post-opp-comment', 'OpportunityUserController@postComment')->name('post-opp-comment');
	Route::get('comments/{id}', 'OpportunityUserController@getPrivateComments')->name('comments');
	
	//Organizations 
	Route::get('organizations','OrganizationController@index')->name('organizations');
	Route::get('organization', 'OrganizationController@organization')->name('organization');
	Route::get('organization/edit/{id}', 'OrganizationController@organization')->name('edit-organization');
	Route::post('new-organization', 'OrganizationController@newOrganization')->name('new-organization');
	Route::post('update-organization/{id}', 'OrganizationController@updateOrganization')->name('update-organization');
	Route::get('organization/delete/{id}', 'OrganizationController@deleteOrganization')->name('delete-organization');

	//admin controller
	Route::get('managers','AdminController@list_managers')->name('managers');
	Route::get('users','AdminController@list_users')->name('users');
	
	Route::post('hr-action','AdminController@hrAction')->name('hr-action');
	
	Route::get('kudos-menu', 'KudosController@index')->name('kudos-menu');
	Route::post('kudos-add', 'KudosController@create')->name('kudos-add');
	Route::post('kudos-like', 'KudosController@like')->name('kudos-like');

	Route::get('taxonomy', 'TaxonomyController@index')->name('taxonomy-list');
	Route::post('taxonomy', 'TaxonomyController@update')->name('taxonomy-update');
	Route::post('taxonomy/status', 'TaxonomyController@status')->name('taxonomy-delete');*/
	

});
Route::group(['prefix' => '','namespace' => 'Auth'],function(){
  
	// Password Reset Routes...
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.token');
	Route::post('password/reset', 'ResetPasswordController@reset');


  });


	
