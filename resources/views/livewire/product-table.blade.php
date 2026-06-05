<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-3 p-2 bg-green-50 border border-green-200 rounded-lg text-green-700 text-xs">
            {{ session('message') }}
        </div>
    @endif

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center justify-between gap-2 mb-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none">
                <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Search..."
                       class="pl-7 pr-7 py-1.5 border border-gray-200 rounded-md text-xs w-full sm:w-48 focus:outline-none focus:border-warasa-orange focus:ring-1 focus:ring-warasa-orange">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times-circle text-xs"></i>
                    </button>
                @endif
            </div>
            <select wire:model.live="status" class="pl-2 pr-5 py-1.5 border border-gray-200 rounded-md text-xs bg-white">
                <option value="">All</option>
                <option value="published">Pub</option>
                <option value="draft">Draft</option>
            </select>
            <select wire:model.live="perPage" class="pl-2 pr-5 py-1.5 border border-gray-200 rounded-md text-xs bg-white">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
        <div class="text-xs text-gray-500 w-full sm:w-auto text-left sm:text-right">
            {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }}
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block border border-gray-200 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-warasa-orange whitespace-nowrap" style="width: 35%;" wire:click="sortBy('name')">
                            Product
                            @if($sortField === 'name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs text-warasa-orange"></i> @endif
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap" style="width: 20%;">Category</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-warasa-orange whitespace-nowrap" style="width: 12%;" wire:click="sortBy('price')">
                            Price
                            @if($sortField === 'price') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs text-warasa-orange"></i> @endif
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap" style="width: 12%;">Stock</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap" style="width: 12%;">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer hover:text-warasa-orange whitespace-nowrap" style="width: 14%;" wire:click="sortBy('created_at')">
                            Created
                            @if($sortField === 'created_at') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs text-warasa-orange"></i> @endif
                        </th>
                        <th class="px-3 py-2 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap" style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors" wire:key="{{ $product->uuid }}">
                        <td class="px-3 py-2">
                            <div class="flex items-center gap-2 min-w-0">
                                @php $firstImage = optional($product->images)->first(); @endphp
                                @if($firstImage && $firstImage->path)
                                    <img src="{{ asset($firstImage->path) }}" class="w-7 h-7 rounded object-cover border border-gray-200 flex-shrink-0" alt="{{ $product->name }}">
                                @else
                                    <div class="w-7 h-7 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-box text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs font-medium text-gray-800 truncate">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400 truncate">{{ \Illuminate\Support\Str::limit($product->ai_generated_title ?? $product->name, 35) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-2 text-gray-600 text-xs truncate">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-3 py-2 font-medium text-gray-800 text-xs whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-3 py-2 text-gray-600 text-xs">{{ number_format($product->stock) }}</td>
                        <td class="px-3 py-2">
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                                {{ $product->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->status === 'published' ? 'Pub' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-500 text-xs whitespace-nowrap">{{ $product->created_at->format('d M Y') }}</td>
                        <td class="px-3 py-2 text-right">
                            <div class="flex items-center justify-end gap-1 flex-shrink-0">
                                <a href="{{ route('products.show', $product->uuid) }}" class="p-1 text-gray-500 hover:text-warasa-orange rounded hover:bg-gray-100" title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->uuid) }}" class="p-1 text-gray-500 hover:text-warasa-orange rounded hover:bg-gray-100" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <button type="button"
                                        onclick="deleteProduct('{{ $product->uuid }}', '{{ addslashes($product->name) }}')"
                                        class="p-1 text-gray-500 hover:text-red-600 rounded hover:bg-gray-100" title="Delete">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-3 py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-inbox text-xl mb-1 block"></i>
                            No products found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden space-y-2">
        @forelse($products as $product)
        <div class="bg-white border border-gray-200 rounded-lg p-3" wire:key="mobile-{{ $product->uuid }}">
            <div class="flex items-start gap-2 mb-2">
                @php $firstImage = optional($product->images)->first(); @endphp
                @if($firstImage && $firstImage->path)
                    <img src="{{ asset($firstImage->path) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200 flex-shrink-0" alt="{{ $product->name }}">
                @else
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-box text-gray-400 text-xs"></i>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-medium text-gray-800 line-clamp-2">{{ $product->name }}</div>
                    <div class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ \Illuminate\Support\Str::limit($product->ai_generated_title ?? $product->name, 35) }}</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-1 text-xs mb-2">
                <div><span class="text-gray-500">Cat:</span> <span class="truncate">{{ $product->category->name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Price:</span> <span class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Stock:</span> <span>{{ number_format($product->stock) }}</span></div>
                <div><span class="text-gray-500">Status:</span> 
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                        {{ $product->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $product->status === 'published' ? 'Pub' : 'Draft' }}
                    </span>
                </div>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                <span class="text-xs text-gray-500">{{ $product->created_at->format('d M Y') }}</span>
                <div class="flex items-center gap-1">
                    <a href="{{ route('products.show', $product->uuid) }}" class="text-gray-500 hover:text-warasa-orange" title="View">
                        <i class="fas fa-eye text-xs"></i>
                    </a>
                    <a href="{{ route('products.edit', $product->uuid) }}" class="text-gray-500 hover:text-warasa-orange" title="Edit">
                        <i class="fas fa-edit text-xs"></i>
                    </a>
                    <button type="button" onclick="deleteProduct('{{ $product->uuid }}', '{{ addslashes($product->name) }}')" class="text-gray-500 hover:text-red-600" title="Delete">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center text-gray-400 text-xs">
            <i class="fas fa-inbox text-xl mb-1 block"></i>
            No products found
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 pb-4">
        @if($products->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-xs">
                <div class="text-gray-500">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}</div>
                <div>{{ $products->onEachSide(1)->links() }}</div>
            </div>
        @else
            <div class="text-center text-xs text-gray-400 py-1">{{ $products->count() }} products</div>
        @endif
    </div>

    <div wire:loading class="fixed bottom-4 right-4 bg-gray-800 text-white px-2 py-1 rounded text-xs shadow flex items-center gap-1 z-50">
        <i class="fas fa-spinner fa-pulse"></i> Loading...
    </div>
</div>

<script>
// Global delete function
async function deleteProduct(uuid, productName) {
    if (!confirm(`Delete "${productName}"? This action cannot be undone.`)) {
        return;
    }
    
    showToast('Deleting...', 'info', 1500);
    
    try {
        const response = await fetch(`/products/${uuid}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showToast('Deleted!', 'success', 1500);
            setTimeout(() => { window.location.reload(); }, 1500);
        } else {
            showToast('Failed: ' + (result.message || 'Unknown'), 'error', 3000);
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'error', 3000);
    }
}
</script>