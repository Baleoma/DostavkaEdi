<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RestaurantResource;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RestaurantResource::collection(Restaurant::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request)
    {
        $create_restaurant = Restaurant::create($request->validated());

        return new RestaurantRequest($create_restaurant);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new RestaurantResource(Category::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->update($request->validated());

        return new RestaurantResource($restaurant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->json(null, 204);
    }
}
