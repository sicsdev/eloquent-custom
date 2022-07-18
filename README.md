# Eloquent Extensions and Helpers

[![PHP CodeSniffer](https://github.com/Saritasa/php-eloquent-custom/workflows/PHP%20Codesniffer/badge.svg)](https://github.com/Saritasa/php-eloquent-custom/actions)
[![Release](https://img.shields.io/github/release/saritasa/php-eloquent-custom.svg)](https://github.com/Saritasa/php-eloquent-custom/releases)
[![PHPv](https://img.shields.io/packagist/php-v/saritasa/eloquent-custom.svg)](http://www.php.net)
[![Downloads](https://img.shields.io/packagist/dt/saritasa/eloquent-custom.svg)](https://packagist.org/packages/saritasa/eloquent-custom)

Custom Extensions for Eloquent

See https://laravel.com/docs/eloquent


## Laravel 5.x/6.x

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

### CamelCaseModel

Extended class Model for use camel case notation in DB.

**Example**:

```php
use Saritasa\Database\Eloquent\Models\CamelCaseModel;

class SomeModel extends CamelCaseModel
{
    //your code
}
```

### CamelCaseBlueprint

Extends class Blueprint for use camel case in base migration methods

**Example**:
```php
use Illuminate\Database\Migrations\Migration;
use Saritasa\Database\Schema\CamelCaseBlueprint as Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSomeTable extends Migration
{
    public function up()
    {
        Schema::create('someTable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('someColumnName');
            $table->timestamps();
        });
    }
}
```

Note: ```$table->timestamps();``` will create columns with names "createdAt" and
"UpdatedAt".

### CamelCaseForeignKeys trait

Use in any model class for get the default foreign key name for this model.

**Example**:

```php
use Saritasa\Database\Eloquent\Models\CamelCaseForeignKeys;

class MyModel extends SomeModelClass
{
    use CamelCaseForeignKeys;
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
