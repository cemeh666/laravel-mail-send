<?php

Route::group(array('prefix'=>config('mail-send.admin-route').'/mail-send','namespace' => 'LaravelModule\MailSend\Controllers','middleware' => ['web']), function() {

	Route::get('/', ['as' => 'mail_index','uses' => 'MailSendController@index']);
	Route::any('/delivery', ['as' => 'mail_delivery','uses' => 'MailSendController@delivery']);

});