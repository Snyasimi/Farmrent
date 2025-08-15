@extends('rentals.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-green-700">{{ $equipment->name }}</h2>
        <a href="{{ route('equipment.index') }}" class="text-green-700 hover:underline">&larr; Back to My Equipment</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex gap-6 items-start">
            @php
                $images = $equipment->images ? json_decode($equipment->images, true) : [];
                $image = count($images) ? asset('storage/' . $images[0]) : 'https://source.unsplash.com/200x200/?tractor,farm-equipment,agriculture&sig=' . $equipment->id;
            @endphp
            <img src="{{ asset('storage/'.$equipment->image) }}" alt="{{ $equipment->name }}" class="w-48 h-48 object-cover rounded">
            <div>
                <div class="mb-2"><span class="font-semibold">Category:</span> {{ $equipment->category->name ?? 'N/A' }}</div>
                <div class="mb-2"><span class="font-semibold">Location:</span> {{ $equipment->location ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Availability:</span>
                    <span class="px-2 py-1 rounded text-xs
                        @if($equipment->availability_status === 'available')
                            bg-green-200 text-green-900
                        @elseif($equipment->availability_status === 'rented')
                            bg-yellow-200 text-yellow-900
                        @else
                            bg-gray-200 text-gray-700
                        @endif
                    ">
                        {{ ucfirst($equipment->availability_status) }}
                    </span>
                </div>
                <div class="mb-2"><span class="font-semibold">Rates:</span>
                    @if($equipment->hourly_rate)
                        Hourly: <span class="font-medium">{{ number_format($equipment->hourly_rate,2) }} KES</span>
                    @endif
                    <br>
                    Daily: <span class="font-medium">{{ number_format($equipment->daily_rate,2) }} KES</span>
                    @if($equipment->weekly_rate)
                        <br>Weekly: <span class="font-medium">{{ number_format($equipment->weekly_rate,2) }} KES</span>
                    @endif
                </div>
                @if($equipment->includes_driver)
                    <div class="mb-2 text-green-700 font-semibold">
                        Includes Driver
                        @if($equipment->driver_additional_cost)
                            (+{{ number_format($equipment->driver_additional_cost,2) }} KES)
                        @endif
                    </div>
                @endif
                <div class="mb-2"><span class="font-semibold">Description:</span> {{ $equipment->description ?? '-' }}</div>
            </div>
        </div>
    </div>

    <h3 class="text-xl font-bold mb-4 text-green-700">Rental History</h3>
    @if($equipment->rentals->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Farmer</th>
                        <th class="py-2 px-3 text-left">Rental Period</th>
                        <th class="py-2 px-3 text-left">Status</th>
                        <th class="py-2 px-3 text-left">Total Cost</th>
                        <th class="py-2 px-3 text-left">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipment->rentals as $rental)
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3">
                                {{ $rental->farmer->name ?? 'N/A' }}
                            </td>
                            <td class="py-2 px-3">
                                {{ \Carbon\Carbon::parse($rental->rental_start_datetime)->format('M d, Y') }}
                                -
                                {{ \Carbon\Carbon::parse($rental->rental_end_datetime)->format('M d, Y') }}
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($rental->status === 'active' || $rental->status === 'confirmed')
                                        bg-green-200 text-green-900
                                    @elseif($rental->status === 'completed')
                                        bg-blue-200 text-blue-900
                                    @else
                                        bg-gray-200 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                {{ number_format($rental->total_cost, 2) }} KES
                            </td>
                            <td class="py-2 px-3">
                                {{ $rental->notes ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded">This equipment has not been rented out yet.</div>
    @endif
</div>
@endsection