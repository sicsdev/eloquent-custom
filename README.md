# Eloquent Extensions and Helpers

[![Build Status](https://travis-ci.org/Saritasa/php-eloquent-custom.svg?branch=master)](https://travis-ci.org/Saritasa/php-eloquent-custom)
[![Release](https://img.shields.io/github/release/saritasa/php-eloquent-custom.svg)](https://github.com/Saritasa/php-eloquent-custom/releases)
[![PHPv](https://img.shields.io/packagist/php-v/saritasa/eloquent-custom.svg)](http://www.php.net)
[![Downloads](https://img.shields.io/packagist/dt/saritasa/eloquent-custom.svg)](https://packagist.org/packages/saritasa/eloquent-custom)

Custom Extensions for Eloquent

See https://laravel.com/docs/eloquent


## Laravel 5.x

Install the ```saritasa/eloquent-custom``` package:

```bash
$ composer require saritasa/eloquent-custom
```

**Optionally** (*if you want to use default migrations*):
If you use Laravel 5.4 or less,
or 5.5+ with [package discovery](https://laravel.com/docs/5.5/packages#package-discovery) disabled,
add the PredefinedMigrationsServiceProvider service provider ``config/app.php``:

```php
'providers' => array(
    // ...
    Saritasa\Database\Eloquent\PredefinedMigrationsServiceProvider::class,
)
```

then you can execute command:

```bash
php artisan vendor:publish --provider=Saritasa\Database\Eloquent\PredefinedMigrationsServiceProvider --tag=migrations
```

## Available classes

### Entity
Extends Eloquent model, adds:

* Ability to set default field values for newly created inheritors

**Example**:
```php
class User extends Entity
{
    protected $defaults = [
        'role' => 'user'
    ]
}
```

now if you create new user it will have role 'user' by default,
if you don't provide it explicitly:

```php

$user = new User(['name' => 'John Doe']);
$this->assertEquals('user', $user->role); // true

$admin = new User['name' => 'Mary', 'role' => 'admin');
$this->assertEquals('admin', $admin->role); // true

```

### SortByName
Global scope for Eloquent models to add sorting by name by default

**Example**:

```php
class SomeModel extends Model {
...
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \Saritasa\Database\Eloquent\Scopes\SortByName());
    }
...
}
``` 

## Contributing
See [CONTRIBUTING](CONTRIBUTING.md) and [Code of Conduct](CONDUCT.md),
if you want to make contribution (pull request)
or just build and test project on your own.

## Resources

* [Changes History](CHANGES.md)
* [Bug Tracker](http://github.com/saritasa/php-eloquent-custom/issues)
* [Authors](http://github.com/saritasa/php-eloquent-custom/contributors)
