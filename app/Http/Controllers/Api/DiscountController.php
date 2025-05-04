<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DiscountResource::collection(Discount::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        $created_discount = Discount::create($request->validated());

        return new DiscountResource($created_discount);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new  DiscountResource(Discount::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        $discount->update($request->validated());

        return new DiscountResource($discount);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response()->json(null, 204);
    }
}
