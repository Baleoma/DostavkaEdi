<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderitemRequest;
use App\Http\Resources\OrderitemResource;
use App\Models\Orderitem;
use Illuminate\Http\Request;

class OrderitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderitemResource::collection(Orderitem::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderitemRequest $request)
    {
        $create_orderiitem = Orderitem::create($request->all());

        return new OrderitemResource($create_orderiitem);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new OrderitemResource(Orderitem::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderitemRequest $request, Orderitem $orderitem)
    {
        $orderitem->update($request->validated());

        return response()->json($orderitem, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderitem $orderitem)
    {
        $orderitem->delete();

        return response()->json(null, 204);
    }
}
