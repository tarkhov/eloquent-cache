# Eloquent cache

Laravel Eloqeunt model auto caching.

### Contents

1. [Compatibility](#compatibility)
2. [Installation](#installation)
   1. [Composer](#composer)
3. [Usage](#usage)
   1. [Inherit model](#inherit-model)
4. [Author](#author)
5. [License](#license)

## Compatibility

Library | Version
------- | -------
Laravel | 5.5

## Installation

### Composer

```bash
composer require tarkhov/eloquent-cache
```

## Usage

### Inherit model

Start using caching features by inheriting `CacheModel` class.

```php
<?php
namespace App;

use EloquentCache\Database\Eloquent\CacheModel;

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

use EloquentCache\Database\Eloquent\CacheModel;

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
* [LinkedIn](https://www.linkedin.com/in/tarkhov/)

## License

This project is licensed under the **MIT License** - see the `LICENSE` file for details.
