<?php
//Route::group(['middleware' => 'web'], function(){
// Đặt tên route theo định dạng Controller.Method
// Không muốn add vào permission thêm Not vào đầu

//Authentication
Route::get('login', ['as' => 'Not.AuthController.show', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['as' => 'Not.AuthController.login', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'Not.AuthController.logout', 'uses' => 'Auth\AuthController@logout']);
/*Route::get('auth/facebook', ['as' => 'Not.AuthController.redirectFacebook', 'uses' => 'Auth\AuthController@redirectToProvider']);
Route::get('auth/facebook/callback', ['as' => 'Not.AuthController.handleFacebook', 'uses' => 'Auth\AuthController@handleProviderCallback']);*/
Route::get('/social/redirect/{provider}', ['as' => 'Not.AuthController.redirect', 'uses' => 'Auth\AuthController@getSocialRedirect']);
Route::get('/social/handle/{provider}', ['as' => 'Not.AuthController.handle', 'uses' => 'Auth\AuthController@getSocialHandle']);

Route::group(['middleware' => 'auth'], function(){
	
	Route::get('/', ['as' => 'Not.HomeController.dashboard', 'uses' => 'HomeController@index']);

	//Role management
	Route::get('role', ['as' => 'RoleController.index', 'uses' => 'RoleController@index']);
	Route::get('role/destroy/{id}', ['as' => 'RoleController.destroy', 'uses' => 'RoleController@destroy']);
	Route::post('role/add', ['as' => 'RoleController.store', 'uses' => 'RoleController@store']);
	Route::get('synchronous/{selectedRole}', ['as' => 'RoleController.synchronousPermissions', 'uses' => 'RoleController@synchronous']);
	Route::get('updatePermission', ['as' => 'Not.RoleController.updatePermission', 'uses' => 'RoleController@updatePermission']);
	 
	//User management
	Route::get('listUser', ['as' => 'Not.UserController.list', 'uses' => 'UserController@listUser']);
    Route::get('user', ['as' => 'UserController.index', 'uses' => 'UserController@index']);
	Route::get('user/show/{id}', ['as' => 'UserController.show', 'uses' => 'UserController@show']);
	Route::post('user/add', ['as' => 'UserController.store', 'uses' => 'UserController@store']);
	Route::match(['get', 'patch'], 'user/edit/{id}', ['as' => 'UserController.update', 'uses' => 'UserController@update']);
	Route::delete('user/destroy', ['as' => 'UserController.destroy', 'uses' => 'UserController@destroy']);

    Route::get('profile', ['as' => 'Not.UserController.profile.show', 'uses' => 'UserController@showProfile']);
    Route::post('profile', ['as' => 'Not.UserController.profile.update', 'uses' => 'UserController@updateProfile']);
    Route::get('password', ['as' => 'Not.UserController.password.show', 'uses' => 'UserController@showPassword']);
    Route::post('password', ['as' => 'Not.UserController.password.update', 'uses' => 'UserController@updatePassword']);
    Route::match(['get', 'post'], 'general', ['as' => 'SettingController.updateGeneral', 'uses' => 'SettingController@updateGeneral']);

    // Setting 
    Route::group(['prefix' => 'setting'], function () {
	    Route::get('{id?}', ['as' => 'SettingController.indexSetting', 'uses' => 'SettingController@index'])->where(['id' => '[0-9]+']);
	    Route::match(['get', 'post'], 'create', ['as' => 'SettingController.createSetting', 'uses' => 'SettingController@create']);
	    Route::match(['get', 'patch'], 'edit/{id}', ['as' => 'SettingController.updateSetting', 'uses' => 'SettingController@update']);
	    Route::post('updateAll', ['as' => 'SettingController.updateAllSetting', 'uses' => 'SettingController@updateAll']);
	    Route::get('destroy/{id}', ['as' => 'SettingController.destroySetting', 'uses' => 'SettingController@destroy']);

	    //Type setting
	    Route::get('type/{id?}', ['as' => 'SettingController.indexType', 'uses' => 'SettingController@indexType'])->where(['id' => '[0-9]+']);
	    Route::match(['get', 'post'], 'type/create', ['as' => 'SettingController.createType', 'uses' => 'SettingController@createType']);
	    Route::match(['get', 'patch'], 'type/edit/{id}', ['as' => 'SettingController.updateType', 'uses' => 'SettingController@updateType']);
	    Route::post('type/updateAll', ['as' => 'SettingController.updateAllType', 'uses' => 'SettingController@updateAllType']);
	    Route::get('type/destroy/{id}', ['as' => 'SettingController.destroyType', 'uses' => 'SettingController@destroyType']);

	    //Group setting
	    Route::get('group', ['as' => 'SettingController.indexGroup', 'uses' => 'SettingController@indexGroup']);
	    Route::match(['get', 'post'], 'group/create', ['as' => 'SettingController.createGroup', 'uses' => 'SettingController@createGroup']);
	    Route::match(['get', 'patch'], 'group/edit/{id}', ['as' => 'SettingController.updateGroup', 'uses' => 'SettingController@updateGroup']);
	    Route::post('group/updateAll', ['as' => 'SettingController.updateAllGroup', 'uses' => 'SettingController@updateAllGroup']);
	    Route::get('group/destroy/{id}', ['as' => 'SettingController.destroyGroup', 'uses' => 'SettingController@destroyGroup']);

	    Route::get('synchronous/{selectedGroup}/{selectedType?}', ['as' => 'SettingController.synchronousModules', 'uses' => 'SettingController@synchronous'])->where(['selectedGroup' => '[0-9]+']);
	});

});
//});
