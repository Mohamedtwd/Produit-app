<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return response()->json(Orders::with('products')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'Total' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.Quantité' => 'required|integer',
            'products.*.prix' => 'required|numeric',
        ]);

        $order = Orders::create([
            'client_id' => $validated['client_id'],
            'Total' => $validated['Total'],
        ]);

        foreach ($validated['products'] as $product) {
            $order->products()->attach($product['id'], [
                'Quantité' => $product['Quantité'],
                'prix' => $product['prix'],
            ]);
        }

        return response()->json($order->load('products'), 201);
    }

    public function show($id)
    {
        $order = Orders::with('products')->findOrFail($id);
        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        $validated = $request->validate([
            'Total' => 'numeric',
            'products' => 'array',
            'products.*.id' => 'exists:products,id',
            'products.*.Quantité' => 'integer',
            'products.*.prix' => 'numeric',
        ]);

        if (isset($validated['Total'])) {
            $order->update(['Total' => $validated['Total']]);
        }

        if (isset($validated['products'])) {
            $order->products()->detach();
            foreach ($validated['products'] as $product) {
                $order->products()->attach($product['id'], [
                    'Quantité' => $product['Quantité'],
                    'prix' => $product['prix'],
                ]);
            }
        }

        return response()->json($order->load('products'), 200);
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->products()->detach();
        $order->delete();
        return response()->json(null, 204);
    }
}
