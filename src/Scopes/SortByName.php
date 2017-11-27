<?php

namespace Saritasa\Database\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope to sort query results by name.
 */
class SortByName implements Scope
{
    private const NAME_ATTRIBUTE = 'name';

    /**
     * Apply the sort by name scope to a given Eloquent query builder.
     *
     * @param  Builder $builder Builder to attach query scope to
     * @param  Model $model Queried model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy(self::NAME_ATTRIBUTE);
    }
}
