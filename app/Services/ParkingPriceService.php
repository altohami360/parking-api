<?php

namespace App\Services;

use Carbon\Carbon;

class ParkingPriceService
{
    public static function calculatePrice($zone_price, $start_time, $end_time)
    {
        $start = Carbon::make($start_time);

        $end = is_null($end_time) ? Carbon::now() : Carbon::make($end_time);

        $total_time_minutes = $end->diffInMinutes($start);

        $zone_price_minutes = $zone_price / 60;

        return ceil($total_time_minutes * $zone_price_minutes);
    }
}
