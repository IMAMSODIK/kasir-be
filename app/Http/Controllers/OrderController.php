<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Config;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $grossAmount = 0;
            $itemDetails = [];
            $orderId = 'ORDER-' . Str::uuid();

            $order = Order::create([
                'order_id' => $orderId,
                'total_amount' => 0,
                'status' => 'pending',
                'customer_table' => $request->customer_table,
            ]);

            foreach ($request->items as $item) {

                $menu = Menu::findOrFail($item['id']);

                $price = (int) $menu->harga;
                $qty = (int) $item['qty'];

                $subtotal = $price * $qty;
                $grossAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'nama_menu' => $menu->nama_menu,
                    'harga' => $price,
                    'qty' => $qty,
                    'note' => $item['note'] ?? null
                ]);

                // 🔹 untuk midtrans
                $itemDetails[] = [
                    'id' => $menu->id,
                    'price' => $price,
                    'quantity' => $qty,
                    'name' => $menu->nama_menu
                ];
            }

            // 🔹 update total
            $order->update([
                'total_amount' => $grossAmount
            ]);

            // 🔹 PARAM MIDTRANS
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => 'Customer',
                ],
                'expiry' => config('midtrans.expiry'),
                'enabled_payments' => config('midtrans.enabled_payments'),
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Checkout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function checkStatus($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json([
            'status' => $order->status
        ]);
    }
}
