<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\LotType;
use App\Models\LotImage;
use App\Models\SaleType;
use App\Models\LotSaleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'zip_code', 
        'public_place',
        'number', 
        'district',
        'city_id',
        'width', 
        'length',
        'area',
        'price',
        'type', 
        'description',
        'lat',
        'long'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => LotType::class,
    ];

    /**
     * Get all of the documents for the SelectionProcess
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lotSaleType(): HasMany
    {
        return $this->hasMany(LotSaleType::class);
    }

    /**
     * Get all of the images for the Lot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(LotImage::class);
    }
}
