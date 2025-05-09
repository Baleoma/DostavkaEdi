<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReviewResource::collection(Review::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        $created_review = Review::create($request->validated());

        return new ReviewResource($created_review);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response(null, 204);
    }

    public function getrestaurantreviews($restaurantId)
    {
        // Ищем отзывы по ID ресторана
        $reviews = Review::with('user:id,name') // загружаем имя пользователя
        ->where('restaurant_id', $restaurantId)
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'Отзывы не найдены'
            ], 404);
        }

        return response()->json([
            'restaurant_id' => $restaurantId,
            'reviews_count' => $reviews->count(),
            'reviews' => $reviews
        ]);
    }
}
