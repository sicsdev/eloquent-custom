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

1. Create fork, checkout it
2. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)** -
    run [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) to ensure, that code follows style guides
3. **Cover added functionality with unit tests** and run [PHPUnit](https://phpunit.de/) to make sure, that all tests pass
4. Update [README.md](README.md) to describe new or changed functionality
5. Add changes description to [CHANGES.md](CHANGES.md) file. Use [Semantic Versioning](https://semver.org/) convention to determine next version number.
6. When ready, create pull request

### Make shortcuts

If you have [GNU Make](https://www.gnu.org/software/make/) installed, you can use following shortcuts:

* ```make cs``` (instead of ```php vendor/bin/phpcs```) -
    run static code analysis with [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
    to check code style
* ```make csfix``` (instead of ```php vendor/bin/phpcbf```) -
    fix code style violations with [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
    automatically, where possible (ex. PSR-2 code formatting violations)
* ```make test``` (instead of ```php vendor/bin/phpunit```) -
    run tests with [PHPUnit](https://phpunit.de/)
* ```make install``` - instead of ```composer install```
* ```make all``` or just ```make``` without parameters -
    invokes described above **install**, **cs**, **test** tasks sequentially -
    project will be assembled, checked with linter and tested with one single command

## Resources

* [Bug Tracker](http://github.com/saritasa/php-eloquent-custom/issues)
* [Code](http://github.com/saritasa/php-eloquent-custom)
* [Changes History](CHANGES.md)
* [Authors](http://github.com/saritasa/php-eloquent-custom/contributors)
