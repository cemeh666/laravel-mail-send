## Installation

In order to install Laravel 5 MailSend, just add

    "laravel-module/mail-send": "dev-master"

to your composer.json. Then run `composer install` or `composer update`.

Then in your `config/app.php` add
```php
    LaravelModule\MailSend\ServiceProvider::class,
```
## Configuration

You can also publish the configuration for this package to further customize table names and model namespaces.  
Just use `php artisan vendor:publish` and a `mail-send.php` file will be created in your app/config directory.

You may now run it with the artisan migrate command:

```bash
php artisan migrate
