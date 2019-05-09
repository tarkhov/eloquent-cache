<?php
namespace EloquentCache\Database\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use EloquentCache\Database\Eloquent\Relations\CacheBelongsToMany;

trait CacheHasRelationships 
{
    protected function newBelongsToMany(Builder $query, Model $parent, $table, $foreignPivotKey, $relatedPivotKey,
                                        $parentKey, $relatedKey, $relationName = null)
    {
        return new CacheBelongsToMany($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }
}
