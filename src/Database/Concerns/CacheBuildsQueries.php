<?php
namespace EloquentCache\Database\Concerns;

use Illuminate\Support\Facades\Cache;
use EloquentCache\Database\CacheKey;

trait CacheBuildsQueries
{
    public function first($columns = ['*'])
    {
        return $this->cacheOne($columns, $this->query->take(1));
    }
}
