<?php

Route::group(['middleware' => 'web', 'prefix' => 'article', 'namespace' => 'Modules\Article\Http\Controllers'], function()
{
	Route::get('listArticle', ['as' => 'Not.ArticleController.list', 'uses' => 'ArticleController@listArticle']);

	Route::get('/', ['as' => 'ArticleController.index', 'uses' => 'ArticleController@index']);
	Route::get('show/{id}', ['as' => 'ArticleController.show', 'uses' => 'ArticleController@show']);
	Route::post('add', ['as' => 'ArticleController.store', 'uses' => 'ArticleController@store']);
	Route::match(['get', 'patch'], 'edit/{id}', ['as' => 'ArticleController.update', 'uses' => 'ArticleController@update']);
	Route::delete('destroy', ['as' => 'ArticleController.destroy', 'uses' => 'ArticleController@destroy']);
});