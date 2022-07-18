<?php

namespace Saritasa\Database\Eloquent\Models\Helpers;

use Illuminate\Database\Eloquent\Model;

class CamelCaseModel extends Model
{
    use CamelCaseForeignKeys;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    public static $snakeAttributes = false;
}
