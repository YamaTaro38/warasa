@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Kategori Produk</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="bg-white dark:bg-dark-card rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-border">
            <thead class="bg-gray-50 dark:bg-dark-bg">
                 etxek
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                \)

            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-gray-50 dark:hover:bg-dark-bg/50">
                    <td class="px-4 py-2 text-sm">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-sm">
                        {{ $category->name }}
                        @if($category->children->count() > 0)
                            <span class="text-xs text-gray-400 ml-1">({{ $category->children->count() }} sub)</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-500">{{ $category->slug }}</td>
                    <td class="px-4 py-2 text-sm">
                        <span class="px-2 py-1 rounded text-xs {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm">{{ $category->sort_order }}</td>
                    <td class="px-4 py-2 text-sm space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('admin.categories.toggle-active', $category) }}" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas {{ $category->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                        </a>
                    </td>
                \)

                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection