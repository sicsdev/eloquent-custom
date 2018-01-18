# Eloquent Extensions and Helpers

[![Build Status](https://travis-ci.org/Saritasa/php-eloquent-custom.svg?branch=master)](https://travis-ci.org/Saritasa/php-eloquent-custom)

Custom Extensions for Eloquent

See https://laravel.com/docs/eloquent


## Laravel 5.x

Install the ```saritasa/eloquent-custom``` package:

```bash
$ composer require saritasa/eloquent-custom
```

**Optionally** (*if you want to use default migrations*):
If you use Laraval 5.4 or less,
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

1. Create fork
2. Checkout fork
3. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)**
4. Run [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) to ensure, that code follows style guides
5. Update [README.md](README.md) to describe new or changed functionality. Add changes description to [CHANGES.md](CHANGES.md) file.
6. When ready, create pull request

## Resources

* [Bug Tracker](http://github.com/saritasa/php-eloquent-custom/issues)
* [Code](http://github.com/saritasa/php-eloquent-custom)
* [Changes History](CHANGES.md)
* [Authors](http://github.com/saritasa/php-eloquent-custom/contributors)
