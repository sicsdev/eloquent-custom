<?php

namespace Saritasa\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    const ID = 'id';
    const DELETED_AT = 'deleted_at';

    protected $defaults = [];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }
}
