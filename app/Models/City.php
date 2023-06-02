<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    /**
     * Get the state that owns the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Scope a query to include state information.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeState($query)
    {
        return $query->select(
            'cities.*',
            'states.title as state',
            'states.letter'
        )
            ->join('states', 'states.id', '=', 'cities.state_id');
    }

    public function getInfoAttribute()
    {
        return $this->title . ' - ' . $this->state->letter;
    }
}
