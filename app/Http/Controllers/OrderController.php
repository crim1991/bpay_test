<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateDeliveryRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\Delivery;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Order::find($id));
    }

    public function calculateDelivery(CalculateDeliveryRequest $request)
    {
        $order = Order::find($request->id);
        $delivery = new Delivery($order->id, $order->lat, $order->long);
        $price = $delivery->calculatePrice();

        return response()->json(['price' => $price]);
    }
}
