<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ResellerOrder;
use App\Models\ResellerProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResellerController extends Controller
{
    public function index()
    {
        $resellerId = auth()->user()->id;
        $orders = ResellerOrder::where('reseller_id', $resellerId)->get();  

        $productIds = $orders->pluck('productID');
        $products = Product::whereIn('productID', $productIds)->get();

        return view('reseller.home', compact('products', 'orders'));
    }

    public function manageProducts(Request $request)
    {
        $resellerId = auth()->user()->id;
        $query = $request->input('search');
        $categoryFilter = $request->input('category');
    
        // Retrieve orders for the retailer
        $orders = ResellerOrder::where('reseller_id', $resellerId)->get();
        $productIds = $orders->pluck('productID');
    
        // Fetch products along with retailer_price
        $products = Product::whereIn('productID', $productIds)
            ->with(['resellerProduct' => function ($query) use ($resellerId) {
                $query->where('resellerID', $resellerId);
            }])
            ->when($query, function ($q) use ($query) {
                return $q->where('productName', 'like', '%' . $query . '%');
            })
            ->paginate(10);
    
        $categories = Category::all();
    
        return view('reseller.manage-product', compact('products', 'categories'));
    }

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
    
        $resellerProduct = new ResellerProduct([
            'resellerID' => auth()->user()->id,
            'productID' => $product->productID,
            'reseller_price' => $request->get('productPrice'), // Use retailer's input price
        ]);
    
        $resellerProduct->save();
    
        return redirect()->route('reseller.manage-product')->with('success', 'Product created successfully.');
    }

    public function edit($productID)
    {
        $product = Product::findOrFail($productID);
        $categories = Category::all();

        // Retrieve or create a RetailerProduct entry for this retailer and product
        $resellerProduct = ResellerProduct::firstOrNew([
            'resellerID' => auth()->user()->id,
            'productID' => $productID
        ]);

        return view('reseller.edit', compact('product', 'categories', 'resellerProduct'));
    }

    public function update(Request $request, $productID)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'reseller_price' => 'required|numeric', // Ensure retailer_price validation
            'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'AvailableStocks' => 'required|integer',
            'categoryID' => 'nullable|exists:categories,categoryID',
        ]);
    
        $product = Product::findOrFail($productID);
    
        if ($request->hasFile('productImage')) {
            if ($product->productImage) {
                Storage::disk('public')->delete($product->productImage);
            }
    
            $image = $request->file('productImage');
            $imagePath = $image->store('product_images', 'public');
            $product->productImage = $imagePath;
        }
    
        $product->productName = $request->input('productName');
        $product->productDescription = $request->input('productDescription');
        $product->AvailableStocks = $request->input('AvailableStocks');
        $product->categoryID = $request->input('categoryID');
        $product->save();
    
        // Update or create RetailerProduct entry with retailer's custom price
        ResellerProduct::updateOrCreate(
            ['resellerID' => auth()->user()->id, 'productID' => $productID],
            ['reseller_price' => $request->input('reseller_price')]
        );
    
        return redirect()->route('reseller.manage-product')->with('success', 'Product updated successfully.');
    
    }

    public function destroy($productID)
    {
        $product = Product::findOrFail($productID);

        if ($product->productImage) {
            Storage::disk('public')->delete($product->productImage);
        }

        $product->delete();

        return redirect()->route('reseller.manage-product')->with('success', 'Product deleted successfully.');
    }
}
