<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;


class SupplierController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('supplier.home', compact('products'));
    }

    //SUPPLIER ManageProducts
    public function manageProducts(Request $request)
    {
        $query = $request->input('seach');
        $categoryFilter = $request->input('category');
    
        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('productName', 'like', '%' .$query. '%');
        })->paginate(10);
    
        $categories = Category::all();

        return view('supplier.manage-product', compact('products', 'categories'));
    }

    //SUPPLIER STORE DATA

    public function store(Request $request)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productPrice' => 'required|numeric',
            'productImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'AvailableStocks' => 'required|integer',
            'categoryID' => 'nullable|exists:categories,categoryID',
        ]);
    
        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imagePath = $image->store('product_images', 'public');
        } else {
            $imagePath = null;
        }
    
        $product = new Product([
            'productName' => $request->get('productName'),
            'productDescription' => $request->get('productDescription'),
            'productPrice' => $request->get('productPrice'),
            'productImage' => $imagePath,
            'AvailableStocks' => $request->get('AvailableStocks'),
            'categoryID' => $request->get('categoryID'),
        ]);
    
        $product->save();
    
        return redirect()->route('supplier.manage-product')->with('success', 'Product created successfully.');
    }


    //SUPPLIER EDIT

    public function edit($productID)
    {
        $product = Product::findOrFail($productID);
        $categories = Category::all();
        return view('supplier.edit', compact('product', 'categories'));
    }

    //SUPPLIER UPDATE
    public function update(Request $request, $productID)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productPrice' => 'required|numeric',
            'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'AvailableStocks' => 'required|integer',
            'categoryID' => 'nullable|exists:categories,categoryID',
        ]);

        $product = Product::findOrFail($productID);

        if ($request->hasFile('productImage')) {
            // Delete the old image if it exists
            if ($product->productImage) {
                Storage::disk('public')->delete($product->productImage);
            }

            // Store the new image
            $image = $request->file('productImage');
            $imagePath = $image->store('product_images', 'public');

            // Update the product with the new image path
            $product->productImage = $imagePath;
        }

        $product->productName = $request->get('productName');
        $product->productDescription = $request->get('productDescription');
        $product->productPrice = $request->get('productPrice');
        $product->AvailableStocks = $request->get('AvailableStocks');
        $product->categoryID = $request->get('categoryID');

        $product->save();

        return redirect()->route('supplier.manage-product')->with('success', 'Product updated successfully.');
    }

    //SUPPLIER DELETE BUTTON
    public function destroy($productID)
    {
        $product = Product::findOrFail($productID);

        $product->delete();

        return redirect()->route('supplier.manage-product')->with('success', 'Product deleted successfully.');
    }

    


}
