@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-green-700">Renter Dashboard</h2>
        <div class="flex gap-3">
            <a href="{{ route('equipment.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Add Equipment</a>
            <a href="{{ route('rentEquipment')}}" class="bg-green-700 text-white px-4 py-2 rounded font-semibold hover:bg-green-800 transition">Rent New Equipment</a>
        </div>
    </div>

    {{-- Analytics Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <div class="bg-green-50 border border-green-200 p-6 rounded shadow text-center">
            <div class="text-4xl font-bold text-green-700">{{ $equipment->count() }}</div>
            <div class="text-green-900 mt-2">Total Equipment</div>
        </div>
        <div class="bg-green-50 border border-green-200 p-6 rounded shadow text-center">
            <div class="text-4xl font-bold text-green-700">{{ $currentRentals->count() }}</div>
            <div class="text-green-900 mt-2">Currently Rented Out</div>
        </div>
        <div class="bg-green-50 border border-green-200 p-6 rounded shadow text-center">
            <div class="text-4xl font-bold text-green-700">
                {{ $equipment->sum('rentals_count') ?? 0 }}
            </div>
            <div class="text-green-900 mt-2">Total Rentals (All Time)</div>
        </div>
    </div>

    {{-- Equipment Management --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-green-800">My Equipment</h3>
    </div>
    @if($equipment->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($equipment as $item)
                @php
                    $defaultImage = 'https://source.unsplash.com/320x180/?tractor,farm-equipment,agriculture&sig=' . $item->id;
                @endphp
                <div class="bg-white rounded-lg shadow border border-green-100 p-4 flex flex-col">
                    <img src="{{ asset('storage/'.$item->image) ?: $defaultImage }}"
                         alt="{{ $item->name }}"
                         class="w-full h-40 object-cover mb-4 rounded">
                    <div class="flex-1">
                        <h4 class="text-green-700 font-bold text-lg mb-1">{{ $item->name }}</h4>
                        <p class="text-gray-600 mb-2">{{ $item->description }}</p>
                        <div class="text-sm text-green-800 font-semibold mt-2">
                            Rented {{ $item->rentals_count ?? 0 }} times
                        </div>
                        @if(isset($item->is_rented) && $item->is_rented)
                            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Currently Rented</span>
                        @endif
                    </div>
                    <a href="{{ route('equipment.show', $item->id) }}"
                       class="mt-4 block bg-green-100 text-green-800 text-center py-2 rounded hover:bg-green-200 transition">View Details</a>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded mb-10">You have not added any equipment yet.</div>
    @endif

    {{-- Current Rentals Table --}}
    <h3 class="text-xl font-semibold mb-4 text-green-800">Current Rentals</h3>
    @if($currentRentals->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Equipment</th>
                        <th class="py-2 px-3 text-left">Farmer</th>
                        <th class="py-2 px-3 text-left">Rental Period</th>
                        <th class="py-2 px-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($currentRentals as $rental)
                        @php
                            $defaultRentalImage = 'https://source.unsplash.com/40x40/?tractor,farm-equipment,agriculture&sig=' . $rental->equipment->id;
                        @endphp
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3 flex items-center gap-2">
                                <img src="{{ $rental->equipment->image }}"
                                     alt=""
                                     class="w-10 h-10 object-cover rounded mr-2">
                                <span>{{ $rental->equipment->name }}</span>
                            </td>
                            <td class="py-2 px-3">{{ $rental->farmer->name ?? 'N/A' }}</td>
                            <td class="py-2 px-3">
                                {{ \Carbon\Carbon::parse($rental->rental_start_datetime)->format('M d, Y') }}
                                -
                                {{ \Carbon\Carbon::parse($rental->rental_end_datetime)->format('M d, Y') }}
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 bg-green-200 text-green-900 rounded text-xs">Ongoing</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded">There are no current rentals for your equipment.</div>
    @endif

    {{-- Equipment management navigation --}}
    <div class="mt-10">
        <a href="{{ route('equipment.index') }}" class="text-green-700 underline">Manage All Equipment</a>
    </div>
</div>
@endsection