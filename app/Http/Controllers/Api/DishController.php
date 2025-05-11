<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DishRequest;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortDirection = $request->input('sort', 'desc');

        $allowedSortDirections = ['asc', 'desc'];
        $sortDirection = in_array($sortDirection, $allowedSortDirections) ? $sortDirection : 'desc';

        $dishes = Dish::orderBy('name', $sortDirection)->get();

        return DishResource::collection($dishes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DishRequest $request)
    {
        $create_dish = Dish::create($request->validated());

        return new DishResource($create_dish);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new DishResource(Dish::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DishRequest $request, Dish $dish)
    {
        $dish->update($request->validated());

        return new DishResource($dish);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();

        return response()->json(null, 204);
    }
}
