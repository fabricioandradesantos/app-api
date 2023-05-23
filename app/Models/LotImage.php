<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lot_images';

    protected $fillable = [
        'lot_id', 'filename',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute(){
        return asset('storage/'.$this->filename);
    }
    
}
