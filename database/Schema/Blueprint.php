<?php

namespace Saritasa\Database\Schema;

use Closure;
use Illuminate\Database\Schema\Blueprint;

class CamelCaseBlueprint extends Blueprint
{
    public function __construct($table, Closure $callback = null, $prefix = '')
    {
        parent::__construct($table, $callback, $prefix);
    }

    /**
     * Add nullable creation and update timestamps to the table by camelcase notation.
     *
     * @param  int  $precision
     * @return void
     */
    public function timestamps($precision = 0)
    {
        $this->timestamp('createdAt', $precision)->nullable();

        $this->timestamp('updatedAt', $precision)->nullable();
    }
}
