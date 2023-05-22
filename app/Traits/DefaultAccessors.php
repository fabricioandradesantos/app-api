<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait DefaultAccessors
{
    /**
     * Get the people info.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function info(): Attribute
    {
        return new Attribute(
            get: function () {
                if (!empty($this->name) && !empty($this->nif)) {
                    return ($this->name . ' - ' . $this->nif);
                }
                if (!empty($this->people->name) && !empty($this->people->nif)) {
                    return ($this->people->name . ' - ' . $this->people->nif);
                }
                if (!empty($this->name)) {
                    return $this->name;
                }
                if (!empty($this->people->name)) {
                    return $this->people->name;
                }
                if (!empty($this->full_name)) {
                    return $this->full_name;
                }
                if (!empty($this->people->full_name)) {
                    return $this->people->full_name;
                }
                return null;
            }
        );
    }

    /**
     * Get the people nif.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function nif(): Attribute
    {
        return new Attribute(
            get: fn ($value) => !empty($value) ? nifMask($value) : (!empty($this->people->nif) ? nifMask($this->people->nif) : null)
        );
    }

    /**
     * Get the people phone.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function phone(): Attribute
    {
        return new Attribute(
            get: fn ($value) => !empty($value) ? phoneMask($value) : (!empty($this->people->phone) ? phoneMask($this->people->phone) : null)
        );
    }

    /**
     * Get the people zipCode.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function zipCode(): Attribute
    {
        return new Attribute(
            get: fn ($value) => !empty($value) ? zipCodeMask($value) : (!empty($this->people->zip_code) ? zipCodeMask($this->people->zip_code) : null)
        );
    }
}
