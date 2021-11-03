<?php

$this->group([

	/**
	*
	* Backend routes main config
	*/
	'namespace' => "System", 
	'as' => "system.", 
	'prefix'	=> "admin",
	// 'middleware' => "", 

], function(){

	$this->group(['middleware' => ["web","system.guest"]], function(){
		$this->get('register/{_token?}',['as' => "register",'uses' => "AuthController@register"]);
		$this->post('register/{_token?}',['uses' => "AuthController@store"]);
		$this->get('login/{redirect_uri?}',['as' => "login",'uses' => "AuthController@login"]);
		$this->post('login/{redirect_uri?}',['uses' => "AuthController@authenticate"]);
	});

	$this->group(['middleware' => ["web","system.auth","system.client_partner_not_allowed"]], function(){
		
		$this->get('logout',['as' => "logout",'uses' => "AuthController@destroy"]);


		$this->group(['middleware' => ["system.update_profile_first"]], function() {

			$this->group(['prefix' => "article", 'as' => "article."], function () {
				$this->get('/',['as' => "index", 'uses' => "ArticleController@index"]);
				$this->get('create',['as' => "create", 'uses' => "ArticleController@create"]);
				$this->post('create',['uses' => "ArticleController@store"]);
				$this->get('edit/{id?}',['as' => "edit", 'uses' => "ArticleController@edit"]);
				$this->get('preview/{id?}',['as' => "preview", 'uses' => "ArticleController@preview"]);
				$this->post('edit/{id?}',['uses' => "ArticleController@update"]);
				$this->any('delete/{id?}',['as' => "destroy", 'uses' => "ArticleController@destroy"]);
			});


		});
	});
});