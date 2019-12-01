<?php
namespace EloquentCache\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class CacheModel extends Model 
{
    use CacheTrait;
}
