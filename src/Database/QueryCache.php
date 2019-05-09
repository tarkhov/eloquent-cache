<?php
namespace EloquentCache\Database;

use Illuminate\Support\Facades\Cache;

trait QueryCache
{
    protected $cache = true;
    protected $cacheKey = null;
    protected $cacheMinutes = null;
    protected $cacheTags = [];

    protected function getCache()
    {
        if ($this->cacheTags) {
            return Cache::tags($this->cacheTags)->get($this->cacheKey);
        } else {
            return Cache::get($this->cacheKey);
        }
    }

    protected function setCache($result)
    {
        if ($this->cacheTags) {
            Cache::tags($this->cacheTags)->put($this->cacheKey, (string) $result, $this->cacheMinutes);
        } else {
            Cache::put($this->cacheKey, (string) $result, $this->cacheMinutes);
        }
    }

    protected function deleteCache()
    {
        if ($this->cacheKey) {
            Cache::forget($this->cacheKey);
        } 

        if ($this->cacheTags) {
            Cache::tags($this->cacheTags)->flush();
        }
    }

    public function cache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    public function cacheKey($key)
    {
        $this->cacheKey = $key;
        return $this;
    }

    public function cacheMinutes($minutes)
    {
        $this->cacheMinutes = $minutes;
        return $this;
    }

    public function cacheTags($tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }

    public function cacheOne($columns, $query)
    {
        if ($this->cache === false) {
            return parent::first($columns);
        }

        if (!$this->cacheKey) {
            $cacheKey = new CacheKey($query);
            $this->cacheKey = $cacheKey->make();
        }

        $result = $this->getCache();
        if ($result) {
            $result = $this->model->newFromBuilder(json_decode($result));
            $result->setCacheKey($this->cacheKey)
                   ->setCacheTags($this->cacheTags);
        } else {
            $result = parent::first($columns);
            if ($result) {
                $this->setCache($result);
                $result->setCacheKey($this->cacheKey)
                       ->setCacheTags($this->cacheTags);
            }
        }

        return $result;
    }

    public function cacheMany($columns, $builder)
    {
        if ($this->cache === false) {
            return parent::get($columns);
        }

        if (!$this->cacheKey) {
            $cacheKey = new CacheKey($builder->getQuery());
            $this->cacheKey = $cacheKey->make();
        }

        $result = $this->getCache();
        if ($result) {
            $result = $builder->getModel()->hydrate((array) json_decode($result));
        } else {
            $result = parent::get($columns);
            if ($result && $result->isNotEmpty()) {
                $this->setCache($result);
            }
        }

        return $result;
    }
}
