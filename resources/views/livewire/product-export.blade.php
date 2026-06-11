{{-- resources/views/livewire/product-export.blade.php --}}
<div>
    <style>
        .export-container { max-width: 1400px; margin: 0 auto; }
        .filter-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; padding: 20px 24px; margin-bottom: 20px; }
        .table-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; }
        .export-btn { padding: 12px 28px; background: linear-gradient(135deg, #ee4d2d, #e63e1f); color: white; border: none; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .export-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(238,77,45,0.3); }
        .export-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .product-checkbox { width: 18px; height: 18px; border-radius: 4px; accent-color: #ee4d2d; cursor: pointer; }
        .product-row { transition: background 0.15s; cursor: pointer; }
        .product-row:hover { background: #f9fafb; }
        .product-row.selected { background: #fef2ee; }
        .table-header { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; padding: 14px 16px; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
        .table-header-cursor { cursor: pointer; }
        .table-header-cursor:hover { color: #ee4d2d; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .status-draft { background: #fef3c7; color: #92400e; }
        .status-published { background: #d1fae5; color: #065f46; }
        .search-input { padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; width: 100%; outline: none; transition: all 0.2s; }
        .search-input:focus { border-color: #ee4d2d; box-shadow: 0 0 0 3px rgba(238,77,45,0.08); }
        .dropdown-filter { padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; background: white; outline: none; cursor: pointer; }
        .stat-card { background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .stat-value { font-size: 22px; font-weight: 700; color: #1f2937; }
        .stat-label { font-size: 12px; color: #6b7280; }
        .select-all-bar { display: none; padding: 12px 16px; background: #fef2ee; border-bottom: 1px solid #fde4d8; align-items: center; justify-content: space-between; font-size: 13px; font-weight: 500; color: #c2410c; }
        .select-all-bar.active { display: flex; }
        .loading-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center; }
        .loading-spinner { background: white; padding: 20px 30px; border-radius: 12px; display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 500; }
    </style>

    <div class="export-container">
        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef2ee;color:#ee4d2d;"><i class="fas fa-box"></i></div>
                <div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-label">Total Produk</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#d1fae5;color:#059669;"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="stat-value">{{ $publishedCount }}</div>
                    <div class="stat-label">Published</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-pen"></i></div>
                <div>
                    <div class="stat-value">{{ $draftCount }}</div>
                    <div class="stat-label">Draft</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="fas fa-file-export"></i></div>
                <div>
                    <div class="stat-value">{{ count($selectedProducts) }}</div>
                    <div class="stat-label">Dipilih</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Cari Produk</label>
                    <input type="text" wire:model.live.debounce.300ms="search" class="search-input w-full" placeholder="Cari nama produk...">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Filter Status</label>
                    <select wire:model.live="status" class="dropdown-filter w-full">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Items per page</label>
                    <select wire:model.live="perPage" class="dropdown-filter w-full">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="selectAll" class="export-btn w-full justify-center" style="padding:10px;font-size:13px;background:#6b7280;">
                        <i class="fas fa-check-double"></i> Pilih Semua
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-card">
            <!-- Select All Bar -->
            <div class="select-all-bar {{ count($selectedProducts) > 0 ? 'active' : '' }}">
                <span><span class="font-bold">{{ count($selectedProducts) }}</span> produk dipilih</span>
                <div class="flex gap-3">
                    <button wire:click="exportSelected" class="export-btn" style="padding:8px 20px;font-size:13px;">
                        <i class="fas fa-file-export"></i> Export ke Shopee
                    </button>
                    <button wire:click="deselectAll" class="text-sm font-medium hover:underline">Batal Pilih</button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="table-header" style="width:40px;">
                                <input type="checkbox" wire:model.live="selectPage" class="product-checkbox">
                            </th>
                            <th class="table-header table-header-cursor" wire:click="sortBy('name')">
                                Nama Produk
                                @if($sortField === 'name')
                                    <i class="fas fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th class="table-header">Kategori</th>
                            <th class="table-header table-header-cursor" wire:click="sortBy('price')">
                                Harga
                                @if($sortField === 'price')
                                    <i class="fas fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th class="table-header">Stok</th>
                            <th class="table-header">Status</th>
                            <th class="table-header table-header-cursor" wire:click="sortBy('created_at')">
                                Tanggal
                                @if($sortField === 'created_at')
                                    <i class="fas fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th class="table-header">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="product-row {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}" 
                            wire:key="{{ $product->uuid }}"
                            onclick="toggleCheckbox(this, {{ $product->id }})">
                            <td class="p-3 text-center" onclick="event.stopPropagation()">
                                <input type="checkbox" value="{{ $product->id }}" wire:model.live="selectedProducts" class="product-checkbox">
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    @php $firstImage = $product->images->first(); @endphp
                                    @if($firstImage && $firstImage->path)
                                        <img src="{{ asset($firstImage->path) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" onerror="this.src='https://placehold.co/40x40/e5e7eb/9ca3af?text=?'">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-800">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">SKU: {{ substr($product->uuid, 0, 8) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                <span class="text-sm text-gray-600">{{ $product->category->name ?? '-' }}</span>
                                @if($product->category && $product->category->shopee_code)
                                    <div class="text-xs text-orange-500">{{ $product->category->shopee_code }}</div>
                                @endif
                            </td>
                            <td class="p-3 text-sm font-medium text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="p-3 text-sm text-gray-600">{{ number_format($product->stock) }}</td>
                            <td class="p-3">
                                <span class="status-badge status-{{ $product->status }}">{{ ucfirst($product->status) }}</span>
                            </td>
                            <td class="p-3 text-sm text-gray-500">{{ $product->created_at->format('d/m/Y') }}</td>
                            <td class="p-3 text-center">
                                <button wire:click="exportSingle({{ $product->id }})" class="text-green-600 hover:text-green-800" title="Export Single">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center">
                                <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Belum ada produk</p>
                                <a href="{{ route('generator') }}" class="text-warasa-orange text-sm font-medium mt-2 inline-block">Buat produk sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleCheckbox(row, productId) {
            const checkbox = row.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        }
        
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('export-products', (data) => {
                if (data.productIds && data.productIds.length > 0) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("products.export.shopee") }}';
                    form.style.display = 'none';
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);
                    
                    const idsInput = document.createElement('input');
                    idsInput.type = 'hidden';
                    idsInput.name = 'product_ids';
                    idsInput.value = JSON.stringify(data.productIds);
                    form.appendChild(idsInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            
            Livewire.on('export-single-product', (data) => {
                if (data.uuid) {
                    window.location.href = '{{ url("/products/export-single") }}/' + data.uuid;
                }
            });
            
            Livewire.on('show-toast', (data) => {
                showToast(data.message, data.type);
            });
        });
        
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed; bottom: 20px; right: 20px;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
                color: white; padding: 10px 16px; border-radius: 8px;
                font-size: 12px; z-index: 9999; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
</div>