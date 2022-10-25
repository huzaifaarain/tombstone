<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = Order::with(['tombstone', 'font', 'icon', 'textColor'])->get();
            return response()->json($orders,Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $data = $request->validated();
            $file = Storage::disk('public')->put('orders', request()->file('image'), 'public');
            Order::create([
                'image' => $file,
                'tombstone_id' => $data['tombstone'],
                'name' => $data['name'],
                'font_id' => $data['font'],
                'text_color_id' => $data['textColor'],
                'date_of_birth' => $data['dateOfBirth'],
                'death_date' => $data['deathDate'],
                'icon_id' => $data['icon'],
                'price' => $data['price'],
            ]);
            return response()->json("Order created.", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        try {
            return response()->json($order, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $data = $request->validated();
            $order->update([
                'tombstone_id' => $data['tombstone'],
                'name' => $data['name'],
                'font_id' => $data['font'],
                'text_color_id' => $data['textColor'],
                'date_of_birth' => $data['dateOfBirth'],
                'death_date' => $data['deathDate'],
                'icon_id' => $data['icon'],
                'price' => $data['price'],
            ]);
            return response()->json("Order updated.", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            if(!empty($order->image) && Storage::disk('public')->exists($order->image)){
                Storage::disk('public')->delete($order->image);
            }
            return response()->json("Order destroyed.", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
