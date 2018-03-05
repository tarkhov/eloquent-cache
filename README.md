# Laravel model caching

Laravel Eloqeunt model auto caching.

### Contents

1. [Installation](#installation)
   1. [Composer](#composer)
2. [Usage](#usage)
   1. [Inherit model](#inherit-model)
3. [Author](#author)
4. [License](#license)

## Installation

### Composer

```bash
composer require tarkhov/laravel-model-caching
```

## Usage

### Inherit model

Start using caching features by inheriting `CacheModel` class.

```php
<?php
namespace App;

use LaravelModelCaching\Database\Eloquent\CacheModel;

class Post extends CacheModel
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
```

```php
<?php
namespace App;

use LaravelModelCaching\Database\Eloquent\CacheModel;

class Category extends CacheModel
{
    protected $cacheTags = ['category'];
    protected $fillable = [
        'title',
        'description',
    ];
}
```

## Author

**Alexander Tarkhov**

* [Facebook](https://www.facebook.com/alex.tarkhov)
* [Twitter](https://twitter.com/alextarkhov)
* [Medium](https://medium.com/@tarkhov)
* [Product Hunt](https://www.producthunt.com/@tarkhov)

## License

This project is licensed under the **MIT License** - see the `LICENSE` file for details.
