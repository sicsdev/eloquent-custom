<?php

namespace Saritasa\Database\Eloquent\Utils;

use DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Query
{
    /**
     * @param \Closure $closure
     * @return array
     */
    public static function captureQueries(\Closure $closure) {
        DB::enableQueryLog();
        $closure();
        $logs = DB::getQueryLog();
        return array_map(function($log) {
            return static::inlineBindings($log['query'], $log['bindings']);
        }, $logs);
    }

    static function inlineBindings(string $query, array $bindings)
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
     * @param EloquentBuilder|QueryBuilder $query $query
     * @return QueryBuilder
     */
    public static function getBaseQuery($query) {
        return ($query instanceof QueryBuilder) ? $query : $query->getQuery();
    }

    /**
     * @param QueryBuilder|EloquentBuilder $query
     * @return string
     */
    static function plainSql($query)
    {
        $query = static::getBaseQuery($query);
        return self::inlineBindings($query->toSql(), $query->getBindings());
    }
}
