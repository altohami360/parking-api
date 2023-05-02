<?php

namespace App\Observers;

use App\Models\Vehicle;

class VehicleObserve
{
    public function creating(Vehicle $vehicle): void
    {
        if (auth()->check()) {
            $vehicle->user_id = auth()->id();
        }
    }

    public function updating(Vehicle $vehicle): void
    {
        if (auth()->check()) {
            $vehicle->user_id = auth()->id();
        }
    }
}
