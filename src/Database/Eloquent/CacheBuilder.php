<?php

namespace LaravelModelCache\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use LaravelModelCache\Database\Concerns\CacheBuildsQueries;

class CacheBuilder extends Builder
{
    use CacheBuildsQueries;

    protected $cache = true;
    protected $cacheKey = null;
    protected $cacheMinutes = null;
    protected $cacheTags = [];

    public function get($columns = ['*'])
    {
        if ($this->cache === true) {
            if (!$this->cacheKey) {
                $this->cacheKey = md5($this->query->toSql());
            }

            $result = $this->getCache();
            if ($result) {
                $result = $this->model->hydrate((array) json_decode($result));
            } else {
                $result = parent::get($columns);
                if ($result && $result->isNotEmpty()) {
                    $this->setCache($result);
                }
            }

            return $result;
        } else {
            return parent::get($columns);
        }
    }

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
}
