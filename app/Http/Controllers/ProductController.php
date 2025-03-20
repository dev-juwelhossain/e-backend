<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addCategory(Request $request)
    {
        // validate unique category
        $request->validate([
            'name' => 'required|unique:category_models',
        ]);

        $data = new CategoryModel();
        $data->name = $request->name;
        $data->save();
        return response()->json([
            'message' => 'Created successfully',
            'data' => $data
        ]);
    }
    // add product
    public function addProduct(Request $request)
    {

        $data = new ProductModel();
        $data->product_name = $request->product_name;
        $data->select_category = $request->select_category;
        $data->availability = $request->availability;
        $data->regular_price = $request->regular_price;
        $data->selling_price = $request->selling_price;
        $data->product_description = $request->product_description;
        if ($request->file('product_image')) {
            $file = $request->file('product_image');
            $filename = date('Ymdhi') . $file->getClientOriginalName();
            $file->move(public_path('admin/product'), $filename);
            $data['product_image'] = $filename;
        }
        $data->save();
        return response()->json([
            'message' => 'Created successfully',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCategory()
    {
        $data = CategoryModel::all();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
