<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class Delivery
{
    CONST PRICE_KM = 10;
    CONST UNIT = "K";

    private $lat_from = '47.0033766';
    private $long_from = '28.858476';
    private $lat_to;
    private $long_to;

    protected $order_id;

    public function __construct($order_id, $lat_to, $long_to)
    {
        $this->order_id = $order_id;
        $this->lat_to = $lat_to;
        $this->long_to = $long_to;
    }

    public function getDistance() {
        $theta = $this->long_from - $this->long_to;
        $miles = (sin(deg2rad($this->lat_from)) * sin(deg2rad($this->lat_to)))
            + (cos(deg2rad($this->lat_from)) * cos(deg2rad($this->lat_to)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $kilometers = $miles * 1.609344;
        return $kilometers;
    }

    public function calculatePrice()
    {
        return number_format($this->getDistance() * self::PRICE_KM, 2);
    }
}
