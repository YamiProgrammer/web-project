<x-supplier-layout>
<div class="container mx-auto py-8">
        <h1 class="text-3xl py-4 border-b mb-10">Products</h1>

        <div class="flex justify-between items-center pt-2 relative mx-auto mb-6 text-gray-600">
            <!-- Search form -->
            <form action="{{ route('supplier.manage-product') }}" method="GET" class="flex space-x-2">
                <input type="text" name="search" class="border-2 border-gray-300 bg-white w-64 h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" placeholder="Search by Product Name" value="{{ request('search') }}">
                <button type="submit" class="text-gray-600 h-4 w-4 fill-current">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <select name="category" id="categoryFilter" class="border-2 border-gray-300 bg-white h-10 px-5 rounded-lg text-sm focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->categoryID }}" {{ request('category') == $category->categoryID ? 'selected' : '' }}>{{ $category->categoryName }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Filter</button>
            </form>

            <!-- Button to toggle modal -->
            <button id="toggleForm" class="middle none center rounded-md bg-[#e5f9f2] border-4 border-[#74e0b9] py-3 px-6 font-sans text-sm font-extrabold uppercase text-[#24ce91] shadow-md transition-all">
                Add New
            </button>
        </div>

        <!-- Modal for Create Product -->
        <div id="createForm" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <button id="closeForm" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900">&times;</button>
                <div class="card-body">
                    <!-- Form for creating a new product -->
                    <form action="{{ route('supplier.manage-product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                            <input type="text" name="productName" id="productName" class="form-control w-full" placeholder="Product Name" required>
                        </div>

                        <div class="form-group mb-4">
                            <textarea name="productDescription" id="productDescription" class="form-control w-full h-44" rows="3" placeholder="Product Description" required></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <input type="number" name="productPrice" id="productPrice" class="form-control w-full" step="0.01" placeholder="Product Price" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="productImage">Product Image</label>
                            <input type="file" name="productImage" id="productImage" class="form-control-file" required accept="image/*">
                        </div>

                        <div class="form-group mb-4">
                            <input type="number" name="AvailableStocks" id="AvailableStocks" class="form-control w-full" placeholder="Available Stocks" required>
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
                            <button type="submit" class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product listing table -->
        <div class="card">
            <div class="card-body">
                <table class="border-collapse w-full">
                    <thead>
                        <tr>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">ID</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Name</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Description</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Price</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Image</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Stocks</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Category</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden sm:table-cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="bg-white sm:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $product->productID }}</td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $product->productName }}</td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $product->productDescription }}</td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $product->productPrice }} ₱</td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    @if ($product->productImage)
                                        <img src="{{ asset('storage/' . $product->productImage) }}" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $product->AvailableStocks }}</td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <a href="{{ route('supplier.manage-product', ['category' => $product->category->categoryID]) }}" class="text-blue-500 hover:underline">{{ $product->category->categoryName }}</a>
                                </td>
                                <td class="w-full lg:w-auto p-3 flex space-x-2 relative lg:static">
                                    <a href="{{ route('supplier.manage-product.edit', ['productID' => $product->productID]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                                    <form action="{{ route('supplier.manage-product.destory', $product->productID) }}" method="POST">
                                        @csrf   
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $products->links() }}
    </div>

    <script>
        // JavaScript to toggle visibility of the create form
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleForm');
            const createForm = document.getElementById('createForm');
            const closeForm = document.getElementById('closeForm');

            toggleButton.addEventListener('click', function() {
                createForm.style.display = 'flex';
            });

            closeForm.addEventListener('click', function() {
                createForm.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === createForm) {
                    createForm.style.display = 'none';
                }
            });
        });
    </script>
</x-supplier-layout>