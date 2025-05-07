<?php

// app/Http/Controllers/Api/OrderController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem; // Исправлено: должно быть OrderItem, а не Orderitem
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Добавлено
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $create_order = Order::create($request->validated());

        return new OrderResource($create_order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new OrderResource(Order::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(null, 204);
    }

    /**
     * Оформление заказа на основе элементов корзины.
     *
     * @return JsonResponse
     */
    public function placeOrder(Request $request): JsonResponse
    {

        // Начинаем транзакцию для целостности данных
        DB::beginTransaction();

        // Получаем текущего пользователя
        $user = Auth::user();

        // Загружаем элементы корзины с блюдами
        $cartItems = Cart::where('user_id', $user->id)
            ->with('dish:id,name,price')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'error' => 'Корзина пуста. Невозможно оформить заказ без товаров.',
            ], 400);
        }

        // Расчёт общей суммы заказа
        $totalPrice = $cartItems->sum(fn($item) => $item->quantity * $item->dish->price);

        // Получаем данные из запроса (адрес, комментарий и т.д.)
        $address = $request->input('address');
        $comment = $request->input('comment');

        if (!$address) {
            return response()->json([
                'error' => 'Адрес доставки обязателен.',
            ], 400);
        }

        // Создаем заказ
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'final_price' => $totalPrice,
            'status_id' => 1, // ID статуса "Новый"
            'address' => $address,
            'comment' => $comment,
            'discount' => 0,
        ]);

        // Добавляем элементы заказа
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $cartItem->dish_id,
                'quantity' => $cartItem->quantity,
            ]);
        }

        // Очищаем корзину пользователя
        Cart::where('user_id', $user->id)->delete();

        // Фиксируем транзакцию
        DB::commit();

        // Возвращаем заказ с элементами через OrderResource
        return response()->json([
            'success' => 'Заказ успешно оформлен.',
            'order' => new OrderResource($order),
        ]);

    }
}
