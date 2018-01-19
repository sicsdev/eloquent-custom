<?php

namespace Saritasa\Database\Eloquent\Utils;

use DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Query
{
    /**
     * Capture SQL queries, called via Eloquent inside argument closure
     *
     * @param \Closure $closure function, that contains DB invocations
     * @return array
     */
    public static function captureQueries(\Closure $closure)
    {
        DB::enableQueryLog();
        $closure();
        $logs = DB::getQueryLog();
        return array_map(function ($log) {
            return static::inlineBindings($log['query'], $log['bindings']);
        }, $logs);
    }

    protected static function inlineBindings(string $query, array $bindings)
    {
        foreach ($bindings as $val) {
            if (is_string($val)) {
                $val = "'$val'";
            }
            $query = str_replace_first('?', $val, $query);
        }
        return $query;
    }

    /**
     * If builder is EloquenBuilder, return it's internal raw QueryBuiler
     *
     * @param EloquentBuilder|QueryBuilder $query Query buiilder
     * @return QueryBuilder
     */
    public static function getBaseQuery($query)
    {
        return ($query instanceof QueryBuilder) ? $query : $query->getQuery();
    }

    /**
     * Present query builder as plain SQL, including inline parameter values
     *
     * @param QueryBuilder|EloquentBuilder $query Query buiilder
     * @return string
     */
    public static function plainSql($query)
    {
        $query = static::getBaseQuery($query);
        return self::inlineBindings($query->toSql(), $query->getBindings());
    }
}
