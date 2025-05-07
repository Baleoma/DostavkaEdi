<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\DishResource;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Загрузите корзину с блюдами
        $cartItems = Cart::where('user_id', $user->id)
            ->with(['dish:id,name,price']) // Используем существующую связь `dish`
            ->get();

        // Загрузите заказы с позициями и блюдами
        $orders = Order::where('user_id', $user->id)
            ->with(['items.dish:id,name,price,image']) // Используем связь `items` и `dish`
            ->get();

        return response()->json([
            'cart' => CartResource::collection($cartItems),
            'orders' => OrderResource::collection($orders),
        ]);
    }


    public function removeFromCart(int $cartItemId): JsonResponse
    {
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)
            ->where('id', $cartItemId)
            ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Элемент корзины не найден'], 404);
        }

        $cartItem->delete();
        return response()->json(['success' => 'Товар удален из корзины']);
    }

    public function placeOrder(): JsonResponse
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('dish')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Корзина пуста'], 400);
        }

        // Создаем заказ
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $cartItems->sum(fn($item) => $item->dish->price * $item->quantity),
            'final_price' => $cartItems->sum(fn($item) => $item->dish->price * $item->quantity), // Пример без скидок
            'status_id' => 1, // ID статуса "Новый"
        ]);

        // Добавляем элементы заказа
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $cartItem->dish_id,
                'quantity' => $cartItem->quantity,
            ]);
        }

        // Очищаем корзину
        Cart::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => 'Заказ успешно оформлен',
            'order' => new OrderResource($order),
        ]);
    }

    public function addToCart(Request $request, int $productId): JsonResponse
    {
        $user = Auth::user();
        $dish = Dish::find($productId);

        if (!$dish) {
            return response()->json(['error' => 'Блюдо не найдено'], 404);
        }

        // Проверяем наличие в корзине
        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('dish_id', $productId)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->increment('quantity');
            return response()->json(['success' => 'Количество увеличено', 'cart_item' => new CartResource($existingCartItem)]);
        }

        // Создаем новый элемент корзины
        $cartItem = Cart::create([
            'user_id' => $user->id,
            'dish_id' => $productId,
            'quantity' => 1,
        ]);

        return response()->json(['success' => 'Товар добавлен в корзину', 'cart_item' => new CartResource($cartItem)]);
    }
}
