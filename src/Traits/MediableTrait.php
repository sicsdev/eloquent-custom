<?php


namespace Saritasa\Database\Eloquent\Traits;

use Saritasa\Database\Eloquent\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait MediableTrait
{
    public function getCoverImage(bool $useCached = true): string
    {
        if ($useCached && $this->cover_image) {
            return $this->cover_image;
        } else {
            /* @var Media $media */
            $media = $this->media()->first();
            return $media ? $media->thumbnail : '';
        }
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')
            ->orderBy('sequence');
    }
}
