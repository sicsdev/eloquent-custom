<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

/**
 * Image or video, attached to Product or Look
 *
 * @property int $id
 * @property string $thumbnail
 * @property string $full
 * @property int $sequence
 * @property int $mediable_id
 * @property string $mediable_type
 * @property-read Model|\Eloquent $mediable
 * @method static Builder|Media whereId($value)
 * @method static Builder|Media whereFull($value)
 * @method static Builder|Media whereThumbnail($value)
 * @method static Builder|Media whereSequence($value)
 * @method static Builder|Media whereMediableId($value)
 * @method static Builder|Media whereMediableType($value)
 * @mixin \Eloquent
 */
class Media extends Model
{
    protected $table = 'medias';
    public $timestamps = false;

    protected $visible = [
        'thumbnail',
        'full'
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
