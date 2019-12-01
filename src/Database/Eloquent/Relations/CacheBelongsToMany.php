<?php
namespace EloquentCache\Database\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use EloquentCache\Database\CacheKey;
use EloquentCache\Database\QueryCache;

class CacheBelongsToMany extends BelongsToMany
{
    use QueryCache;

    public function first($columns = ['*'])
    {
        return $this->cacheOne($columns, $this->take(1));
    }

    public function get($columns = ['*'])
    {
        $builder = $this->query->applyScopes();
        $columns = $builder->getQuery()->columns ? [] : $columns;
        $builder->addSelect(
            $this->shouldSelect($columns)
        );
        return $this->cacheMany($columns, $builder);
    }

    public function attach($id, array $attributes = [], $touch = true)
    {
        parent::attach($id, $attributes, $touch);
    }

    public function detach($ids = null, $touch = true)
    {
        parent::detach($ids, $touch);
    }

    public function sync($ids, $detaching = true)
    {
        parent::sync($ids, $detaching);
    }

    public function syncWithoutDetaching($ids)
    {
        parent::syncWithoutDetaching($ids);
    }

    public function toggle($ids, $touch = true)
    {
        parent::toggle($ids, $touch);
    }

    public function updateExistingPivot($id, array $attributes, $touch = true)
    {
        parent::updateExistingPivot($id, $attributes, $touch);
    }
}
