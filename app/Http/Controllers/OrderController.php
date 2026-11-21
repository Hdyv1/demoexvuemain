<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Order::orderBy('created_at', 'desc')->with(['user','place'])->get());
    }
    public function userOrders(){
        return response()->json(Order::where('user_id', auth::id())->orderBy('created_at', 'desc')->with(['user','place'])->get());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order();
        $order->user_id = auth::id();
        $order->place_id = $request->place;
        $order->date = $request->date;
        $order->payMethod = $request->payMethod;
        $order->name = $request->name;
        $order->save();
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order -> status = $request -> status;
        $order->save();
        return response()->json($order->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
