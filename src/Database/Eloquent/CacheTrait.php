<?php
namespace EloquentCache\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    protected $cacheKey = null;
    protected $cacheTags = [];

    public function newEloquentBuilder($query)
    {
        return new CacheBuilder($query);
    }

    protected function newBelongsToMany(Builder $query, Model $parent, $table,
                                        $foreignPivotKey, $relatedPivotKey,
                                        $parentKey, $relatedKey, $relationName = null)
    {
        return new Relations\CacheBelongsToMany($query, $parent, $table, $foreignPivotKey,
                                                $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }

    public function deleteCache()
    {
        if ($this->cacheKey) {
            Cache::forget($this->cacheKey);
        } 

        if ($this->cacheTags) {
            Cache::tags($this->cacheTags)->flush();
        }
    }

    public function save(array $options = [])
    {
        $result = parent::save($options);
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

    public function getCacheKey()
    {
        return $this->cacheKey;
    }

    public function setCacheKey($key)
    {
        $this->cacheKey = $key;
        return $this;
    }

    public function getCacheTags()
    {
        return $this->cacheTags;
    }

    public function setCacheTags($tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }
}
