<?php

namespace App\Models;

use App\Models\SaleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotSaleType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lot_sale_type';

    /**
     * Scope a query to include state information.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected $fillable = [
        'lot_id',
        'sale_type_id'
    ];

    /**
     * Get the city that owns the Unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function saleType(): BelongsTo
    {
        return $this->belongsTo(SaleType::class, 'sale_type_id');
    }

}
