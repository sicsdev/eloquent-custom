<?php

namespace Saritasa\Database\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class CamelCaseModel extends Model
{
    use CamelCaseForeignKeys;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    public static $snakeAttributes = false;
}
