<?php

namespace Saritasa\Database\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Saritasa\Database\Eloquent\Entity;

/**
 * Class Product
 *
 * @property boolean $id
 * @property string $name
 * @property float $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string price_display
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereUpdatedAt($value)
 */
class Product extends Entity
{
    protected $table = 'products';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'price'
    ];

    protected $guarded = [];

    public function getPriceDisplayAttribute() {
        return '$'. number_format($this->price, 2);
    }
}
