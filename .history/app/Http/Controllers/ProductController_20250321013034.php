<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductController extends Controller
{
    // add category
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
    // update category
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:category_models,name,' . $id,
        ]);

        $category = CategoryModel::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json(['message' => 'Category updated successfully']);
    }
    // delete category
    public function deleteCategory($id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
    // add product
    public function addProduct(Request $request)
    {
        $data = new ProductModel();
        $data->product_name = $request->product_name;
        $data->select_category = $request->select_category;
        $data->availability = $request->availability;
        $data->regular_price = $request->regular_price;
        $data->selling_price  = $request->selling_price;
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

    // product update
    public function updateProduct(Request $request, $id)
    {
        $data = ProductModel::findOrFail($id);

        $data->product_name = $request->product_name;
        $data->select_category = $request->select_category;
        $data->availability = $request->availability;
        $data->regular_price = $request->regular_price;
        $data->selling_price = $request->selling_price;
        $data->product_description = $request->product_description;

        if ($request->file('product_image')) {
            // Delete the old image if it exists
            if ($data->product_image && file_exists(public_path('admin/product/' . $data->product_image))) {
                unlink(public_path('admin/product/' . $data->product_image));
            }

            // Upload new image
            $file = $request->file('product_image');
            $filename = date('Ymdhi') . $file->getClientOriginalName();
            $file->move(public_path('admin/product'), $filename);
            $data->product_image = $filename;
        }

        $data->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $data
        ]);
    }
    public function deleteProduct($id)
    {
        $data = ProductModel::findOrFail($id);

        // Delete the image file if it exists
        if ($data->product_image && file_exists(public_path('admin/product/' . $data->product_image))) {
            unlink(public_path('admin/product/' . $data->product_image));
        }
        $data->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
    // get category data
    public function getCategory()
    {
        $data = CategoryModel::all();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }

    // get products
    public function getProduct()
    {
        $data = ProductModel::all();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }
    // get product by category
    public function getCategoryProduct($category)
    {
        $data = ProductModel::where('select_category', $category)->get();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }
    // get product by id
    public function getProductById($id)
    {
        $data = ProductModel::find($id);
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
