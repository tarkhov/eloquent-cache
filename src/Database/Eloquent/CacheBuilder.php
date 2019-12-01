<?php
namespace EloquentCache\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use EloquentCache\Database\QueryCache;

class CacheBuilder extends Builder
{
    use QueryCache;

    public function first($columns = ['*'])
    {
        return $this->cacheOne($columns, $this->query->take(1));
    }

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
