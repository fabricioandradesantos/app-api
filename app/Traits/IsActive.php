<?php

namespace App\Traits;

use App\Enums\Common\Active;

trait IsActive
{
    public function isActive()
    {
        return Active::from($this->is_active)->name();
    }
}
