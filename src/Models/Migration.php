<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Migration
 *
 * @property int $id
 * @property string $migration
 * @property int $batch
 * @method static Builder|Migration whereId($value)
 * @method static Builder|Migration whereMigration($value)
 * @method static Builder|Migration whereBatch($value)
 * @mixin \Eloquent
 */
class Migration extends Model
{
    protected $table = 'migrations';

    public $timestamps = false;

    protected $fillable = [
        'migration',
        'batch'
    ];

    protected $guarded = [];
}
