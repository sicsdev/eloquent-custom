<?php

namespace Saritasa\Database\Eloquent\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Trait for model. Changes slug, when name is updated.
 *
 * @property string $slug
 * @property array $attributes
 */
trait SlugTrait
{
    /**
     * Override set name
     *
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->slug = $slug = str_slug($name);

        if ($this instanceof Model && self::sameSlugs($this, $slug)->exists()) {
            $similarSlugs = self::similarSlugs($this, $slug);
            $postfix = 1;
            $this->slug = $slug.$postfix;
            while ($similarSlugs->has($this->slug)) {
                $postfix++;
                $this->slug = $slug.$postfix;
            }
        }
    }
    
    private static function sameSlugs(Model $model, string $slug): Builder
    {
        $query = $model->newQuery()
            ->where('slug', $slug);
        if ($model->exists) {
            $query->where($model->getKeyName(), '<>', $model->getKey());
        }
        return $query;
    }

    private static function similarSlugs(Model $model, string $slug): Collection
    {
        $query = $model->newQuery()
            ->select('slug')
            ->where('slug', 'LIKE', $slug.'%');
        if ($model->exists) {
            $query->where($model->getKeyName(), '<>', $model->getKey());
        }
        return $query->get()->keyBy('slug');
    }
}
