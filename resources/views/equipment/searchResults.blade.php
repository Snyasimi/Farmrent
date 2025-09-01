@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <h2 class="text-3xl font-bold text-green-700">Available Equipment for Rent</h2>
        <form action="{{ route('searchEquipment') }}" method="GET" class="w-full sm:w-auto">
            <div class="flex rounded shadow border border-green-300 bg-white">
                <input 
                    type="text" 
                    name="equipmentName" 
                    placeholder="Search equipment..." 
                    value="{{ request('search') }}"
                    class="w-full sm:w-64 px-3 py-2 rounded-l outline-none focus:ring-2 focus:ring-green-200"
                >
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-r hover:bg-green-800 transition">
                    Search
                </button>
            </div>
        </form>
    </div>

    @if($equipment->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($equipment as $item)
                @php
                    $defaultImage = 'https://source.unsplash.com/320x180/?tractor,farm-equipment,agriculture&sig=' . $item->id;
                @endphp
                <div class="bg-white rounded-lg shadow border border-green-100 p-4 flex flex-col">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : $defaultImage }}"
                         alt="{{ $item->name }}"
                         class="w-full h-40 object-cover mb-4 rounded">
                    <div class="flex-1">
                        <h3 class="text-green-700 font-bold text-lg mb-1">{{ $item->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ Str::limit($item->description, 100) }}</p>
                        <div class="text-green-900 font-semibold mb-2">
                            KES {{ number_format($item->hourly_rate  ?? 0, 2) }} / hour
                        </div>
                        <div class="text-green-900 font-semibold mb-2">
                            KES {{ number_format($item->daily_rate ?? 0, 2) }} / day
                        </div>
                        <div class="text-green-900 font-semibold mb-2">
                            KES {{ number_format($item->weekly_rate ?? 0, 2) }} / week
                        </div>
                    </div>
                    <a href="{{ route('equipment.show', $item->id) }}"
                       class="mt-2 block bg-green-100 text-green-800 text-center py-2 rounded hover:bg-green-200 transition font-semibold">
                        View Equipment
                    </a>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $equipment->links() }}
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded">No equipment found matching your search.</div>
    @endif
</div>
@endsection