<x-reseller-layout>
    <div class="container p-6">
        <h1 class="pb-6">Reseller Homepage</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3">
            @foreach($products as $product)
                <div class="relative flex w-96 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">

                    <div class="relative mx-4 mt-4 h-auto overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700">
                        <img src="{{ asset('storage/' . $product->productImage) }}" class="card-img-top" alt="{{ $product->productName }}">
                        <div class="p-6">
                            <div class="mb-2 items-center">
                                <p class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 antialiased">{{ $product->productName }}</h5>
                                <p class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 antialiased">
                                @if ($product->resellerProduct)
                                        <p class="">Price: {{ $product->resellerProduct->reseller_price }}₱</p>
                                    @endif
                                </p>
                            </div>
                            <p class="block font-sans text-sm font-normal leading-normal text-gray-700 antialiased opacity-75">{{ $product->productDescription }}</p>
                            <p class="block font-sans text-base font-medium leading-relaxed text-blue-gray-900 my-2 antialiased">
                                @foreach ($product->orders ?? [] as $order)
                                        <div>Available Stocks: {{ $order->quantity }}</div>
                                @endforeach
                            </p>
                            <form action="{{ route('reseller.orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="productID" value="{{ $product->productID }}">
                                <div class="form-group">
                                    <input type="number" name="quantity" class="form-control block w-full select-none rounded-lg bg-blue-gray-900/10 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-blue-gray-900 transition-all hover:scale-105" id="quantity" placeholder="Quantity" min="1" max="{{ $product->AvailableStocks }}" required>
                                </div>
                                <button type="submit" class="block w-full select-none rounded-lg bg-gray py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-blue-gray-900 transition-all hover:scale-105 focus:scale-105 focus:opacity-[0.85] active:scale-100 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-reseller-layout>