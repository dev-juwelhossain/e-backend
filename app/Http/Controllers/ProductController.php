<?php

namespace App\Http\Controllers;

use App\Models\SubCategoryModel;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\OrderModel;

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
    // sub category
    public function subCategory(Request $request)
    {

        // validate unique category
        $request->validate([
            'name' => 'required|unique:sub_category_models',
        ]);

        $data = new SubCategoryModel();
        $data->name = $request->name;
        // $data->select_category = $request->select_category;
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
    // update category
    public function updateSubCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:sub_category_models,name,' . $id,
        ]);

        $category = SubCategoryModel::findOrFail($id);
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
    // delete category
    public function deleteSubCategory($id)
    {
        $category = SubCategoryModel::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
    // add product
    public function addProduct(Request $request)
    {

        // Initialize ProductModel instance
        $data = new ProductModel();
        $data->product_name = $request->product_name;
        $data->select_category = $request->select_category;
        $data->availability = $request->availability;
        $data->regular_price = $request->regular_price;
        $data->selling_price = $request->selling_price;
        $data->product_description = $request->product_description;
        $data->p_short_des = $request->p_short_des;
        $data->select_sub_category = $request->select_sub_category;
        $data->color = $request->color;
        $data->size = $request->size;
        $data->type = $request->type;

        // Handle product image upload
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = date('Ymdhi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/product'), $filename);
            $data->product_image = $filename;
        }

        // Handle image gallery upload
        if ($request->hasFile('image_gallary')) {
            $files = $request->file('image_gallary');
            $filenames = [];

            // If only one file is uploaded, wrap it in an array
            if (!is_array($files)) {
                $files = [$files];
            }

            // Loop through files and save them
            foreach ($files as $file) {
                $filename = date('Ymdhi') . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('admin/product/gallery'), $filename);
                $filenames[] = $filename;
            }

            // Store the file paths as JSON in the database
            $data->image_gallary = json_encode($filenames);
        } else {
            // If no gallery images are uploaded, set it to null
            $data->image_gallary = null;
        }

        // Try to save the product data
        try {
            $data->save(); // Save the product to the database
            return response()->json([
                'message' => 'Product created successfully',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            // Handle any errors that occur during saving
            return response()->json([
                'error' => 'Failed to create product',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // product update
    public function updateProduct(Request $request, $id)
    {

        $data = ProductModel::find($id);
        $data->product_name = $request->product_name;
        $data->select_category = $request->select_category;
        $data->availability = $request->availability;
        $data->regular_price = $request->regular_price;
        $data->selling_price  = $request->selling_price;
        $data->product_description = $request->product_description;
        $data->p_short_des = $request->p_short_des;
        $data->select_sub_category = $request->select_sub_category;
        $data->color = $request->color;
        $data->size = $request->size;
        $data->type = $request->type;
        if ($request->file('product_image')) {
            $file = $request->file('product_image');
            $filename = date('Ymdhi') . $file->getClientOriginalName();
            $file->move(public_path('admin/product'), $filename);
            $data['product_image'] = $filename;
        }

        // Handle image gallery upload
        if ($request->hasFile('image_gallary')) {
            $files = $request->file('image_gallary');
            $filenames = [];

            // If only one file is uploaded, wrap it in an array
            if (!is_array($files)) {
                $files = [$files];
            }

            // Loop through files and save them
            foreach ($files as $file) {
                $filename = date('Ymdhi') . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('admin/product/gallery'), $filename);
                $filenames[] = $filename;
            }

            // Store the file paths as JSON in the database
            $data->image_gallary = json_encode($filenames);
        } else {
            // If no gallery images are uploaded, set it to null
            $data->image_gallary = null;
        }

        $data->save();
        return response()->json(['message' => 'Product updated successfully']);
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
    // get product by sub category
    public function getSubCategoryProduct($sub_category)
    {
        $data = ProductModel::where('select_sub_category', $sub_category)->get();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }
    // get product by type
    public function getProductByType($type)
    {
        $data = ProductModel::where('type', $type)->get();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }
    // get sub category
    public function getSubCategory()
    {
        $data = SubCategoryModel::all();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }

    // get products
    public function getProduct()
    {
        // Retrieve all products from the database
        $data = ProductModel::all();

        // Iterate over the products and decode the 'image_gallary' JSON field
        $data->each(function ($product) {
            // Decode the 'image_gallary' JSON field into a PHP array
            if ($product->image_gallary) {
                $product->image_gallary = json_decode($product->image_gallary);
            }
        });

        // Return the products in the response
        return response()->json([
            'message' => 'Products retrieved successfully',
            $data, // Return the data as a JSON object
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
        // Retrieve the product by ID
        $data = ProductModel::find($id);

        // If the product is found, decode the 'image_gallary' field
        if ($data) {
            // Decode the 'image_gallary' JSON field into a PHP array if it exists
            if ($data->image_gallary) {
                $data->image_gallary = json_decode($data->image_gallary);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                $data // Return the product data
            ]);
        } else {
            return response()->json([
                'message' => 'Product not found'
            ], 404); // Return 404 if product is not found
        }
    }


    // add order
    // inout field -> name, email, phone,address, cart array, tatal price , user_id
    public function addOrder(Request $request)
    {
        // generate order id
        $order_id = 'ORD' . rand(1000, 9999);
        $data = new OrderModel();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->cart = json_encode($request->cart);
        $data->total_price = $request->total_price;
        $data->user_id = $request->user_id;
        $data->order_id = $order_id;
        $data->p_method = $request->p_method;
        $data->size = $request->size;
        $data->color = $request->color;
        $data->save();
        return response()->json([
            'message' => 'Created successfully',
            $data
        ]);
    }
    // get order
    public function getOrder()
    {
        $data = OrderModel::all();
        // cart should be json
        $data->map(function ($item) {
            $item->cart = json_decode($item->cart);
            return $item;
        });
        return response()->json([
            'message' => 'Created successfully',
            'data' => $data
        ]);
    }
    // get order by id
    public function getOrderById($id)
    {
        // make it group by user id
        $data = OrderModel::where('user_id', $id)->get();
        $data->map(function ($item) {
            $item->cart = json_decode($item->cart);
            return $item;
        });
        return response()->json([
            'message' => 'Created successfully',
            'data' => $data
        ]);
    }
    // order confirm by id
    public function confirmOrder($id)
    {
        $data = OrderModel::findOrFail($id);
        $data->status = 1;
        $data->save();
        return response()->json([
            'message' => 'Order confirmed successfully',
            // 'data' => $data
        ]);
    }
    // delete order
    public function deleteOrder($id)
    {
        $data = OrderModel::findOrFail($id);
        $data->delete();
        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
    // get order by date range
    public function getOrderByDate($from, $to)
    {
        $data = OrderModel::whereBetween('created_at', [$from, $to])
            ->orWhereDate('created_at', $from)
            ->orWhereDate('created_at', $to)
            ->get();

        $data->map(function ($item) {
            $item->cart = json_decode($item->cart);
            return $item;
        });

        return response()->json([
            'message' => 'Orders fetched successfully',
            'data' => $data
        ]);
    }
    public function getSubCategoryByCategory($name)
    {
        // Find all products that match the category name
        $products = ProductModel::where('select_category', $name)->get();

        // Check if any products exist for the given category
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this category'], 404);
        }

        // Extract the unique subcategories from the filtered products
        $subCategories = $products->pluck('select_sub_category')->unique();

        // Return the unique subcategories
        return response()->json($subCategories);
    }
}
