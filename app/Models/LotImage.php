<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotImage extends Model
{
    protected $fillable = [
        'lot_id', 'filename',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute(){
        return asset('storage/'.$this->filename);
    }
    
}
