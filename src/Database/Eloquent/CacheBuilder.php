<?php
namespace EloquentCache\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use EloquentCache\Database\Concerns\CacheBuildsQueries;
use EloquentCache\Database\CacheKey;
use EloquentCache\Database\QueryCache;

class CacheBuilder extends Builder
{
    use QueryCache,
        CacheBuildsQueries;

    public function get($columns = ['*'])
    {
        $builder = $this->applyScopes();
        return $this->cacheMany($columns, $builder);
    }

    public function create(array $attributes = [])
    {
        $result = parent::create($attributes);
        if ($result) {
            $this->deleteCache();
        }
        return $result;
    }

    public function update(array $values)
    {
        $result = parent::update($values);
        if ($result) {
            $this->deleteCache();
        }
        return $result;
    }

    public function delete()
    {
        $result = parent::delete();
        if ($result) {
            $this->deleteCache();
        }
        return $result;
    }
}
