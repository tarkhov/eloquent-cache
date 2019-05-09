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
}
