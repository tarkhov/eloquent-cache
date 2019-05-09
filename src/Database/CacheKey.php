<?php
namespace EloquentCache\Database;

class CacheKey
{
    protected $query = null;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function make()
    {
        $sql = str_replace('?', '%s', $this->query->toSql());
        $bindings = array_map(function ($binding) {
            return is_numeric($binding) ? $binding : "'" . $binding . "'";
        }, $this->query->getBindings());
        return md5(vsprintf($sql, $bindings));
    }
}
