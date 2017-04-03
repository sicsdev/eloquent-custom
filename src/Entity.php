<?php

namespace Saritasa\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $defaults = [];

    public function __construct(array $attributes = [])
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }
}
