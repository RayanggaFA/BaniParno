@extends('layouts.app')

@section('title', 'Edit Keluarga')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Keluarga</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('families.update', $family->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        {{-- Nama Keluarga --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Keluarga</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                   value="{{ old('name', $family->name) }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Cabang --}}
        <div class="mb-4">
            <label for="branch" class="block text-gray-700 font-bold mb-2">Cabang</label>
            <input type="text" name="branch" id="branch" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                   value="{{ old('branch', $family->branch) }}" required>
            @error('branch')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Generasi --}}
        <div class="mb-4">
            <label for="generation" class="block text-gray-700 font-bold mb-2">Generasi</label>
            <input type="number" name="generation" id="generation" min="1"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                   value="{{ old('generation', $family->generation) }}" required>
            @error('generation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="description" id="description" rows="4"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('description', $family->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Warna --}}
        <div class="mb-4">
            <label for="color" class="block text-gray-700 font-bold mb-2">Warna Keluarga</label>
            <input type="color" name="color" id="color" class="w-16 h-10 p-1 border rounded"
                   value="{{ old('color', $family->color ?? '#000000') }}">
            @error('color')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <label for="status" class="block text-gray-700 font-bold mb-2">Status</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                <option value="">-- Pilih Status --</option>
                <option value="active" {{ old('status', $family->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $family->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
            <a href="{{ route('families.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
