<?php

Route::group(array('prefix'=>config('mail-send.admin-route').'/mail-send','namespace' => 'LaravelModule\MailSend\Controllers','middleware' => ['web']), function() {

	Route::get('/',         ['as' => 'mail_index',      'uses' => 'MailSendController@index']);
	Route::any('/delivery', ['as' => 'mail_delivery',   'uses' => 'MailSendController@delivery']);
	Route::any('/{id}/send',     ['as' => 'mail_send',  'uses' => 'MailSendController@send']);
	Route::any('/{id}/edit',     ['as' => 'delivery_edit',    'uses' => 'MailSendController@deliveryEdit']);
	Route::any('/{id}/delete',   ['as' => 'delivery_delete',  'uses' => 'MailSendController@deliveryDelete']);
	Route::post('/send/mass',    ['as' => 'send_mass',  'uses' => 'MailSendController@sendMass']);
	Route::any('/settings/template', ['as' => 'mail_template',   'uses' => 'MailSendController@settingsTemplate']);


});