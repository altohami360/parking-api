<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Services\ParkingPriceService;

class ParkingController extends Controller
{
    public function start(StartParkingRequest $request)
    {
        if (Parking::active()->where('vehicle_id', $request->vehicle_id)->exists()) {
            return response()->json([
                'error' => ['general' => ['can\'t start parking twice using same vehicle']]
            ]);
        }

        $parking = Parking::create($request->validated());

        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    public function show(Parking $parking)
    {
        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    public function end(Parking $parking)
    {
        $parking->load('vehicle', 'zone');

        $parking->update([
            'end_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone->price_per_hour, $parking->start_time, now())
        ]);


        return ParkingResource::make($parking);
    }
}
