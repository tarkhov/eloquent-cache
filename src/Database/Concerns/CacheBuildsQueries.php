<?php
namespace EloquentCache\Database\Concerns;

use Illuminate\Support\Facades\Cache;

trait CacheBuildsQueries
{
    public function first($columns = ['*'])
    {
        if ($this->cache === true) {
            if (!$this->cacheKey) {
                $this->cacheKey = sha1($this->query->take(1)->toSql());
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
        } else {
            return parent::first($columns);
        }
    }
}
