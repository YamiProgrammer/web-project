<x-supplier-layout>
<div class="container mx-auto py-8">
    <h1 class="text-3xl py-3 border-b mb-8">Edit Product</h1>

    <form action="{{ route('supplier.manage-product.update', ['productID' => $product->productID]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-4">
            <label for="productName">Product Name</label>
            <input type="text" name="productName" id="productName" class="form-control w-full" value="{{ $product->productName }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="productDescription">Product Description</label>
            <textarea name="productDescription" id="productDescription" class="form-control w-full" rows="3" required>{{ $product->productDescription }}</textarea>
        </div>

        <div class="form-group mb-4">
            <label for="productPrice">Product Price</label>
            <input type="number" name="productPrice" id="productPrice" class="form-control w-full" step="0.01" value="{{ $product->productPrice }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="productImage">Product Image</label>
            <input type="file" name="productImage" id="productImage" class="form-control-file" accept="image/*">
            @if ($product->productImage)
                <img src="{{ asset('storage/' . $product->productImage) }}" alt="{{ $product->productName }}" style="max-width: 100px; max-height: 100px;">
            @else
                No Image
            @endif
        </div>

        <div class="form-group mb-4">
            <label for="AvailableStocks">Available Stocks</label>
            <input type="number" name="AvailableStocks" id="AvailableStocks" class="form-control w-full" value="{{ $product->AvailableStocks }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="categoryID">Category</label>
            <select name="categoryID" id="categoryID" class="form-control" required>
                <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->categoryID }}">{{ $category->categoryName }}</option>
                    @endforeach
            </select>
        </div>

        <div class="buttons flex justify-end">
            <button type="submit" class="btn btn-primary border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500">Update Product</button>    
        </div>
        
    </form>
    </div>
</x-supplier-layout>