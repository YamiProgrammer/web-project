<x-reseller1-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl py-4 border-b mb-10">Edit Product</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form for editing the product -->
        <form action="{{ route('reseller.manage-product.update', ['productID' => $product->productID]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product details inputs -->
            <div class="mb-4">
                <label for="productName" class="block text-gray-700 text-sm font-bold mb-2">Product Name:</label>
                <input type="text" id="productName" name="productName" value="{{ old('productName', $product->productName) }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="productDescription" class="block text-gray-700 text-sm font-bold mb-2">Product Description:</label>
                <textarea id="productDescription" name="productDescription" rows="4" class="form-textarea w-full">{{ old('productDescription', $product->productDescription) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="reseller_price" class="block text-gray-700 text-sm font-bold mb-2">Reseller's Price (₱):</label>
                <input type="number" id="reseller_price" name="reseller_price" value="{{ old('reseller_price', $resellerProduct->reseller_price ?? $product->productPrice) }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="productImage" class="block text-gray-700 text-sm font-bold mb-2">Product Image:</label>
                @if ($product->productImage)
                    <img src="{{ asset('storage/' . $product->productImage) }}" alt="Product Image" class="w-64 mb-4">
                @else
                    <p>No image available</p>
                @endif
                <input type="file" id="productImage" name="productImage" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="AvailableStocks" class="block text-gray-700 text-sm font-bold mb-2">Available Stocks:</label>
                <input type="number" id="AvailableStocks" name="AvailableStocks" value="{{ old('AvailableStocks', $product->AvailableStocks) }}" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="categoryID" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <select id="categoryID" name="categoryID" class="form-select w-full">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->categoryID }}" {{ old('categoryID', $product->categoryID) == $category->categoryID ? 'selected' : '' }}>{{ $category->categoryName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Product</button>
                <a href="{{ route('reseller.manage-product') }}" class="ml-4 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-reseller1-layout>
