@extends('rentals.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Add Equipment</h2>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label class="block font-medium mb-1">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="w-full border rounded p-2" required value="{{ old('name') }}">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Category --}}
        <div>
            <label class="block font-medium mb-1">Category <span class="text-red-500">*</span></label>
            <select name="category_id" class="w-full border rounded p-2" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Hourly Rate --}}
            <div>
                <label class="block font-medium mb-1">Hourly Rate (KES)</label>
                <input type="number" name="hourly_rate" step="0.01" min="0" class="w-full border rounded p-2"
                       value="{{ old('hourly_rate') }}">
                @error('hourly_rate') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Daily Rate --}}
            <div>
                <label class="block font-medium mb-1">Daily Rate (KES) <span class="text-red-500">*</span></label>
                <input type="number" name="daily_rate" step="0.01" min="0" class="w-full border rounded p-2"
                       required value="{{ old('daily_rate') }}">
                @error('daily_rate') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Weekly Rate --}}
            <div>
                <label class="block font-medium mb-1">Weekly Rate (KES)</label>
                <input type="number" name="weekly_rate" step="0.01" min="0" class="w-full border rounded p-2"
                       value="{{ old('weekly_rate') }}">
                @error('weekly_rate') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Includes Driver --}}
            <div>
                <label class="block font-medium mb-1">Includes Driver?</label>
                <select name="includes_driver" class="w-full border rounded p-2">
                    <option value="0" {{ old('includes_driver') == '0' ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('includes_driver') == '1' ? 'selected' : '' }}>Yes</option>
                </select>
                @error('includes_driver') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Driver Additional Cost --}}
            <div>
                <label class="block font-medium mb-1">Driver Additional Cost (KES)</label>
                <input type="number" name="driver_additional_cost" step="0.01" min="0" class="w-full border rounded p-2"
                       value="{{ old('driver_additional_cost') }}">
                @error('driver_additional_cost') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Availability Status --}}
        <div>
            <label class="block font-medium mb-1">Availability Status</label>
            <select name="availability_status" class="w-full border rounded p-2">
                <option value="available" {{ old('availability_status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="rented" {{ old('availability_status') == 'rented' ? 'selected' : '' }}>Rented</option>
                <option value="maintenance" {{ old('availability_status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            @error('availability_status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Location --}}
        <div>
            <label class="block font-medium mb-1">Location</label>
            <input type="text" name="location" class="w-full border rounded p-2" value="{{ old('location') }}">
            @error('location') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Images --}}
        <div>
            <label class="block font-medium mb-1">Image (jpg/png/webp, max 2MB)</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded p-2">
            @error('image') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-600">Save</button>
        </div>
    </form>
</div>
@endsection