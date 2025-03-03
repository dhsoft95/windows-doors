<!-- product-performance-matrix.blade.php -->
<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold tracking-tight">Product Performance Matrix</h2>
            <x-filament::button
                wire:click="$refresh"
                color="secondary"
                icon="heroicon-o-user"
                size="sm"
            >
                Refresh
            </x-filament::button>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Featured vs Non-featured -->
            <div class="rounded-lg border border-gray-200 p-4">
                <h3 class="mb-2 text-sm font-medium text-gray-900">Featured Status</h3>
                <div class="flex flex-col space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Featured</span>
                        <span class="text-xs font-medium">{{ $matrix['featured']['featured'] }}</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        @php
                            $featuredTotal = $matrix['featured']['featured'] + $matrix['featured']['not_featured'];
                            $featuredPercent = $featuredTotal > 0 ? ($matrix['featured']['featured'] / $featuredTotal) * 100 : 0;
                        @endphp
                        <div class="h-2 rounded-full bg-primary-600" style="width: {{ $featuredPercent }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Non-featured</span>
                        <span class="text-xs font-medium">{{ $matrix['featured']['not_featured'] }}</span>
                    </div>
                </div>
            </div>

            <!-- On Sale vs Regular Price -->
            <div class="rounded-lg border border-gray-200 p-4">
                <h3 class="mb-2 text-sm font-medium text-gray-900">Sale Status</h3>
                <div class="flex flex-col space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">On Sale</span>
                        <span class="text-xs font-medium">{{ $matrix['sale']['on_sale'] }}</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        @php
                            $saleTotal = $matrix['sale']['on_sale'] + $matrix['sale']['regular_price'];
                            $salePercent = $saleTotal > 0 ? ($matrix['sale']['on_sale'] / $saleTotal) * 100 : 0;
                        @endphp
                        <div class="h-2 rounded-full bg-success-600" style="width: {{ $salePercent }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Regular Price</span>
                        <span class="text-xs font-medium">{{ $matrix['sale']['regular_price'] }}</span>
                    </div>
                </div>
            </div>

            <!-- In Stock vs Out of Stock -->
            <div class="rounded-lg border border-gray-200 p-4">
                <h3 class="mb-2 text-sm font-medium text-gray-900">Inventory Status</h3>
                <div class="flex flex-col space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">In Stock</span>
                        <span class="text-xs font-medium">{{ $matrix['stock']['in_stock'] }}</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        @php
                            $stockTotal = $matrix['stock']['in_stock'] + $matrix['stock']['out_of_stock'];
                            $stockPercent = $stockTotal > 0 ? ($matrix['stock']['in_stock'] / $stockTotal) * 100 : 0;
                        @endphp
                        <div class="h-2 rounded-full bg-info-600" style="width: {{ $stockPercent }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Out of Stock</span>
                        <span class="text-xs font-medium">{{ $matrix['stock']['out_of_stock'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Active vs Inactive -->
            <div class="rounded-lg border border-gray-200 p-4">
                <h3 class="mb-2 text-sm font-medium text-gray-900">Active Status</h3>
                <div class="flex flex-col space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Active</span>
                        <span class="text-xs font-medium">{{ $matrix['active']['active'] }}</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200">
                        @php
                            $activeTotal = $matrix['active']['active'] + $matrix['active']['inactive'];
                            $activePercent = $activeTotal > 0 ? ($matrix['active']['active'] / $activeTotal) * 100 : 0;
                        @endphp
                        <div class="h-2 rounded-full bg-warning-600" style="width: {{ $activePercent }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Inactive</span>
                        <span class="text-xs font-medium">{{ $matrix['active']['inactive'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Price Range Distribution -->
{{--        <div class="mt-6">--}}
{{--            <h3 class="mb-2 text-sm font-medium text-gray-900">Price Range Distribution</h3>--}}
{{--            <div class="grid grid-cols-4 gap-2">--}}
{{--                @foreach ($matrix['price_ranges'] as $range => $count)--}}
{{--                    <div class="rounded-lg border border-gray-200 p-3 text-center">--}}
{{--                        <div class="text-sm font-medium">${{ $range }}</div>--}}
{{--                        <div class="mt-1 text-xl font-semibold">{{ $count }}</div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Discount Range Distribution -->--}}
{{--        <div class="mt-6">--}}
{{--            <h3 class="mb-2 text-sm font-medium text-gray-900">Discount Distribution</h3>--}}
{{--            <div class="grid grid-cols-4 gap-2">--}}
{{--                <div class="rounded-lg border border-gray-200 p-3 text-center">--}}
{{--                    <div class="text-sm font-medium">No Discount</div>--}}
{{--                    <div class="mt-1 text-xl font-semibold">{{ $matrix['discount_ranges']['no_discount'] }}</div>--}}
{{--                </div>--}}
{{--                <div class="rounded-lg border border-gray-200 p-3 text-center">--}}
{{--                    <div class="text-sm font-medium">Small (0-20%)</div>--}}
{{--                    <div class="mt-1 text-xl font-semibold">{{ $matrix['discount_ranges']['small'] }}</div>--}}
{{--                </div>--}}
{{--                <div class="rounded-lg border border-gray-200 p-3 text-center">--}}
{{--                    <div class="text-sm font-medium">Medium (21-50%)</div>--}}
{{--                    <div class="mt-1 text-xl font-semibold">{{ $matrix['discount_ranges']['medium'] }}</div>--}}
{{--                </div>--}}
{{--                <div class="rounded-lg border border-gray-200 p-3 text-center">--}}
{{--                    <div class="text-sm font-medium">Large (>50%)</div>--}}
{{--                    <div class="mt-1 text-xl font-semibold">{{ $matrix['discount_ranges']['large'] }}</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Top Products Table -->--}}
{{--        <div class="mt-6">--}}
{{--            <h3 class="mb-2 text-sm font-medium text-gray-900">Top Products</h3>--}}
{{--            <div class="overflow-hidden rounded-lg border border-gray-200">--}}
{{--                <table class="min-w-full divide-y divide-gray-200">--}}
{{--                    <thead class="bg-gray-50">--}}
{{--                    <tr>--}}
{{--                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>--}}
{{--                        <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>--}}
{{--                        <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="bg-white divide-y divide-gray-200">--}}
{{--                    @foreach ($topProducts as $product)--}}
{{--                        <tr>--}}
{{--                            <td class="px-3 py-2 whitespace-nowrap text-xs font-medium text-gray-900">{{ $product['name'] }}</td>--}}
{{--                            <td class="px-3 py-2 whitespace-nowrap text-xs text-right text-gray-500">${{ number_format($product['current_price'], 2) }}</td>--}}
{{--                            <td class="px-3 py-2 whitespace-nowrap text-xs text-right">--}}
{{--                                @if ($product['discount'] > 0)--}}
{{--                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">--}}
{{--                                            {{ $product['discount'] }}% off--}}
{{--                                        </span>--}}
{{--                                @else--}}
{{--                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">--}}
{{--                                            Regular--}}
{{--                                        </span>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Low Stock Products Table -->--}}
{{--        <div class="mt-6">--}}
{{--            <h3 class="mb-2 text-sm font-medium text-gray-900">Low Stock Products</h3>--}}
{{--            <div class="overflow-hidden rounded-lg border border-gray-200">--}}
{{--                <table class="min-w-full divide-y divide-gray-200">--}}
{{--                    <thead class="bg-gray-50">--}}
{{--                    <tr>--}}
{{--                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>--}}
{{--                        <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>--}}
{{--                        <th scope="col" class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="bg-white divide-y divide-gray-200">--}}
{{--                    @foreach ($lowStockProducts as $product)--}}
{{--                        <tr>--}}
{{--                            <td class="px-3 py-2 whitespace-nowrap text-xs font-medium text-gray-900">{{ $product['name'] }}</td>--}}
{{--                            <td class="px-3 py-2 whitespace-nowrap text-xs text-right">--}}
{{--                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">--}}
{{--                                        {{ $product['stock'] }} left--}}
{{--                                    </span>--}}
{{--                            </td>--}}
{{--                            <td class="px-3 py-2 whitespace-nowrap text-xs text-right text-gray-500">${{ number_format($product['current_price'], 2) }}</td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    @if (count($lowStockProducts) === 0)--}}
{{--                        <tr>--}}
{{--                            <td colspan="3" class="px-3 py-2 whitespace-nowrap text-xs text-center text-gray-500">No low stock products found</td>--}}
{{--                        </tr>--}}
{{--                    @endif--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
    </x-filament::card>
</x-filament::widget>
