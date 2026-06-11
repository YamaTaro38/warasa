<div>
    @if (session()->has('message'))
    <div class="mb-3 px-3 py-2 bg-green-50 border border-green-200 rounded-md text-green-700 text-xs flex items-center gap-1.5">
        <i class="fas fa-check-circle text-xs"></i>
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="mb-3 px-3 py-2 bg-red-50 border border-red-200 rounded-md text-red-700 text-xs flex items-center gap-1.5">
        <i class="fas fa-exclamation-circle text-xs"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
        <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $products->total() }}</p>
                    <p class="text-xs text-gray-500">Total Produk</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-orange-500 text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-green-600">{{ $products->where('status', 'published')->count() }}</p>
                    <p class="text-xs text-gray-500">Published</p>
                </div>
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-yellow-600">{{ $products->where('status', 'draft')->count() }}</p>
                    <p class="text-xs text-gray-500">Draft</p>
                </div>
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pen text-yellow-500 text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-600">{{ count($selectedProducts) }}</p>
                    <p class="text-xs text-gray-500">Dipilih</p>
                </div>
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-double text-blue-500 text-sm"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row flex-wrap items-center justify-between gap-3 mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." class="pl-8 pr-3 py-1.5 border border-gray-200 rounded-lg text-sm w-56 focus:outline-none focus:border-orange-400 focus:ring-1 focus:ring-orange-400">
                @if($search)
                <button wire:click="$set('search', '')" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times-circle text-xs"></i>
                </button>
                @endif
            </div>
            <select wire:model.live="status" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-orange-400">
                <option value="">Semua Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
            <select wire:model.live="perPage" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-orange-400">
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
            </select>
        </div>
        <div class="text-xs text-gray-500">
            Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    @if(count($selectedProducts) > 0)
    <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg flex flex-wrap items-center justify-between gap-2">
        <div class="text-sm text-orange-700">
            <span class="font-semibold">{{ count($selectedProducts) }}</span> produk dipilih
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <select wire:model="bulkAction" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-orange-400">
                <option value="">Aksi Massal</option>
                <option value="publish">Publish</option>
                <option value="draft">Draft</option>
                <option value="archive">Archive</option>
                <option value="delete">Delete</option>
            </select>
            <button wire:click="applyBulkAction" wire:loading.attr="disabled" class="px-3 py-1.5 bg-orange-500 text-white text-sm rounded-lg hover:bg-orange-600 transition">
                Terapkan
            </button>
            <!-- Tombol Export menggunakan exportSelected -->
            <button wire:click="exportSelected" wire:loading.attr="disabled" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                <span wire:loading.remove><i class="fas fa-file-excel mr-1"></i> Export Shopee</span>
                <span wire:loading><i class="fas fa-spinner fa-pulse mr-1"></i> Exporting...</span>
            </button>
            <button wire:click="$set('selectedProducts', []); $set('selectPage', false)" class="px-3 py-1.5 text-gray-500 hover:text-gray-700 text-sm">
                Batal
            </button>
        </div>
    </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left w-10">
                            <input type="checkbox" wire:model="selectPage" class="rounded border-gray-300 w-4 h-4">
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 cursor-pointer hover:text-orange-500" wire:click="sortBy('name')">
                            <div class="flex items-center gap-1">
                                Nama Produk
                                @if($sortField === 'name')
                                <i class="fas fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kategori</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 cursor-pointer hover:text-orange-500" wire:click="sortBy('price')">
                            <div class="flex items-center gap-1">
                                Harga
                                @if($sortField === 'price')
                                <i class="fas fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Stok</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 cursor-pointer hover:text-orange-500" wire:click="sortBy('created_at')">
                            <div class="flex items-center gap-1">
                                Tanggal
                                @if($sortField === 'created_at')
                                <i class="fas fa-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600 w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition" wire:key="{{ $product->uuid }}">
                        <a href="{{ route('products.show', $product->uuid) }}" class="absolute inset-0 z-10">
                            <td class="px-4 py-3">
                                <input type="checkbox" value="{{ $product->uuid }}" wire:model="selectedProducts" class="rounded border-gray-300 w-4 h-4">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @php $firstImage = optional($product->images)->first(); @endphp
                                    @if($firstImage && $firstImage->path)
                                    <img src="{{ asset($firstImage->path) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" onerror="this.src='https://placehold.co/40x40/e5e7eb/9ca3af?text=?'">
                                    @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-400">{{ \illuminate\support\Str::limit($product->ai_generated_title ?? $product->name, 40) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $product->category->name ?? '—' }}
                                @if($product->category && $product->category->shopee_code)
                                <div class="text-xs text-orange-500">{{ $product->category->shopee_code }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ number_format($product->stock) }}
                            </td>
                            <td class="px-4 py-3">
                                @if($product->status === 'published')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i> Published
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-pen mr-1 text-xs"></i> Draft
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                                {{ $product->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('products.edit', $product->uuid) }}" class="p-1.5 text-gray-500 hover:text-orange-500 rounded hover:bg-gray-100" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button type="button" wire:click="exportSingle('{{ $product->uuid }}')" class="p-1.5 text-gray-500 hover:text-green-600 rounded hover:bg-gray-100" title="Export Shopee">
                                        <i class="fas fa-file-excel text-sm"></i>
                                    </button>
                                    <button type="button" wire:click="confirmDelete('{{ $product->uuid }}')" class="p-1.5 text-gray-500 hover:text-red-600 rounded hover:bg-gray-100" title="Hapus">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </a>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-3 block"></i>
                            <p>Belum ada produk</p>
                            <a href="{{ route('generator') }}" class="text-orange-500 text-sm font-medium mt-2 inline-block">Buat produk sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            @if($products->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2">
                <div class="text-xs text-gray-500">
                    Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                </div>
                <div>
                    {{ $products->onEachSide(1)->links() }}
                </div>
            </div>
            @else
            <div class="text-center text-xs text-gray-400">
                Total {{ $products->count() }} produk
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(0,0,0,0.5);">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden" wire:click.self="cancelDelete">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Konfirmasi Hapus</h3>
                </div>
                <button type="button" wire:click="cancelDelete" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-5 py-4">
                @if($isBulkDelete)
                <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus <strong class="text-red-600">{{ $bulkDeleteCount }}</strong> produk? Tindakan ini tidak dapat dibatalkan.</p>
                @else
                <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus produk <strong class="text-red-600">"{{ $productToDeleteName }}"</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                @endif
            </div>
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-2">
                <button type="button" wire:click="cancelDelete" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" wire:click="performDelete" wire:loading.attr="disabled" class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <span wire:loading.remove>Hapus</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Export Modal -->
    @if($showExportModal)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(0,0,0,0.5);">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-excel text-green-500"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Export ke Shopee</h3>
                </div>
                <button type="button" wire:click="closeExportModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-5 py-4">
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        Anda akan mengexport <strong class="text-green-600">{{ count($selectedProducts) }}</strong> produk ke format Excel Shopee.
                    </p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-800">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-lightbulb mt-0.5"></i>
                        <div>
                            <p class="font-medium mb-1">Tips sebelum export:</p>
                            <ul class="text-xs list-disc list-inside space-y-0.5 text-yellow-700">
                                <li>Pastikan produk sudah memiliki kategori yang valid</li>
                                <li>Pastikan produk memiliki gambar</li>
                                <li>Pastikan harga dan stok sudah diisi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-2">
                <button type="button" wire:click="closeExportModal" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" wire:click="exportToShopee" wire:loading.attr="disabled" class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                    <span wire:loading.remove><i class="fas fa-file-export mr-1"></i> Export Sekarang</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin mr-1"></i> Memproses...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed bottom-4 right-4 bg-gray-800 text-white px-3 py-2 rounded-lg text-sm shadow-lg flex items-center gap-2 z-50">
        <i class="fas fa-spinner fa-pulse"></i>
        <span>Memuat...</span>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('download-export', (data) => {
            if (data.path) {
                // Buat link download
                const link = document.createElement('a');
                link.href = '/storage/' + data.path;
                link.download = link.href.split('/').pop();
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    });
</script>
@endpush