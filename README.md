# PHP Blade Directives

Custom Extensions for Eloquent

See https://laravel.com/docs/5.4/eloquent


## Laravel 5.x

Install the ``saritasa/php-eloquent-custom`` package:

```bash
$ composer require saritasa/php-eloquent-custom
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

## Contributing

1. Create fork
2. Checkout fork
3. Develop locally as usual. **Code must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/)**
4. When ready, create pull request

## Resources

* [Bug Tracker](http://github.com/saritasa/php-eloquent-custom/issues)
* [Code](http://github.com/saritasa/php-eloquent-custom)
