<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return response()->json(Products::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'Quantité' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $product = Products::create($validated);
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);
        return response()->json($product, 200);
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $validated = $request->validate([
            'Nom' => 'string|max:255',
            'prix' => 'numeric',
            'Quantité' => 'integer',
            'categorie_id' => 'exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
