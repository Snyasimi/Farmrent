@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-green-700">My Equipment</h2>
        <div class="flex gap-3">
            <a href="{{ route('equipment.create') }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-600">
                + Add Equipment
            </a>
            <a href="{{ route('rentalRequests') }}" class="bg-green-100 text-green-800 px-4 py-2 rounded border border-green-400 hover:bg-green-200">
                View Rent Requests
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($equipment->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Image</th>
                        <th class="py-2 px-3 text-left">Name</th>
                        <th class="py-2 px-3 text-left">Category</th>
                        <th class="py-2 px-3 text-left">Rates</th>
                        <th class="py-2 px-3 text-left">Availability</th>
                        <th class="py-2 px-3 text-left">Location</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipment as $item)
                        @php
                            $images = $item->images ? json_decode($item->images, true) : [];
                            $image = count($images) ? asset('storage/' . $images[0]) : 'https://source.unsplash.com/40x40/?tractor,farm-equipment,agriculture&sig=' . $item->id;
                        @endphp
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3">
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="w-12 h-12 object-cover rounded">
                            </td>
                            <td class="py-2 px-3 font-semibold">
                                <a href="{{ route('equipment.show', $item->id) }}" class="text-green-700 hover:underline">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td class="py-2 px-3">
                                {{ $item->category->name ?? 'N/A' }}
                            </td>
                            <td class="py-2 px-3 text-sm">
                                @if($item->hourly_rate)
                                    <span class="block">Hourly: <span class="font-medium">{{ number_format($item->hourly_rate,2) }} KES</span></span>
                                @endif
                                <span class="block">Daily: <span class="font-medium">{{ number_format($item->daily_rate,2) }} KES</span></span>
                                @if($item->weekly_rate)
                                    <span class="block">Weekly: <span class="font-medium">{{ number_format($item->weekly_rate,2) }} KES</span></span>
                                @endif
                                @if($item->includes_driver)
                                    <span class="block text-green-700">Includes Driver
                                        @if($item->driver_additional_cost)
                                            (+{{ number_format($item->driver_additional_cost,2) }} KES)
                                        @endif
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($item->availability_status === 'available')
                                        bg-green-200 text-green-900
                                    @elseif($item->availability_status === 'rented')
                                        bg-yellow-200 text-yellow-900
                                    @else
                                        bg-gray-200 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($item->availability_status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                {{ $item->location ?? '-' }}
                            </td>
                            <td class="py-2 px-3">
                                <a href="{{ route('equipment.show', $item->id) }}" class="text-green-700 hover:underline">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-yellow-50 text-yellow-900 p-4 rounded">You have not added any equipment yet.</div>
    @endif
</div>
@endsection