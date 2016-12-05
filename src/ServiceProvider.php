<?php namespace LaravelModule\MailSend;

use Illuminate\Support\ServiceProvider as LServiceProvider;

class ServiceProvider extends LServiceProvider
{

	public function boot()
	{

		//Указываем что пакет должен опубликовать при установке
		$this->publishes([__DIR__ . '/../config/mail-send.php' => config_path() . "/mail-send.php"]);
		$this->publishes([__DIR__ . '/../Job/' => base_path("/app/Jobs")]);
		$this->publishes([__DIR__ . '/../database/migrations/' => base_path("/database/migrations")], 'migrations');

		// Routing
		if (!$this->app->routesAreCached()) {
			include __DIR__ . '/routes.php';
		}

		//Указывам где искать вью и какой неймспейс им задать
		$this->loadViewsFrom(__DIR__ . '/../views', 'module-send');
		$this->publishes([
			__DIR__.'/../views' => base_path('resources/views/vendor/module-send'),
		]);
	}

	public function register()
	{

	}
}