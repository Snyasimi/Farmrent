@extends('rentals.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-green-700">Rental Details</h2>
        <a href="{{ route('rentals.index') }}" class="text-green-700 hover:underline">&larr; Back to My Rentals</a>
    </div>

    <div class="bg-white rounded shadow p-6 mb-8">
        <div class="flex gap-8 items-start">
            @php
                $images = $rental->equipment->images ? json_decode($rental->equipment->images, true) : [];
                $image = count($images) ? asset('storage/' . $images[0]) : 'https://source.unsplash.com/120x120/?tractor,farm-equipment,agriculture&sig=' . $rental->equipment->id;
            @endphp
            <img src="{{ $image }}" alt="{{ $rental->equipment->name }}" class="w-28 h-28 object-cover rounded">
            <div>
                <div class="mb-2"><span class="font-semibold">Equipment:</span>
                    <a href="{{ route('equipment.show', $rental->equipment->id) }}" class="text-green-700 hover:underline">{{ $rental->equipment->name }}</a>
                </div>
                <div class="mb-2"><span class="font-semibold">Category:</span> {{ $rental->equipment->category->name ?? 'N/A' }}</div>
                <div class="mb-2"><span class="font-semibold">Location:</span> {{ $rental->equipment->location ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Owner:</span> {{ $rental->renter->name ?? 'N/A' }}</div>
            </div>
        </div>
        <hr class="my-6">
        <div class="mb-2"><span class="font-semibold">Farmer (Renter):</span> {{ $rental->farmer->name ?? 'N/A' }}</div>
        <div class="mb-2"><span class="font-semibold">Rental Period:</span>
            {{ \Carbon\Carbon::parse($rental->rental_start_datetime)->format('M d, Y H:i') }}
            &ndash;
            {{ \Carbon\Carbon::parse($rental->rental_end_datetime)->format('M d, Y H:i') }}
        </div>
        <div class="mb-2"><span class="font-semibold">Duration:</span> {{ $rental->duration_hours }} hours</div>
        <div class="mb-2"><span class="font-semibold">Status:</span>
            <span class="px-2 py-1 rounded text-xs
                @if($rental->status === 'active' || $rental->status === 'confirmed')
                    bg-green-200 text-green-900
                @elseif($rental->status === 'completed')
                    bg-blue-200 text-blue-900
                @elseif($rental->status === 'cancelled')
                    bg-red-200 text-red-900
                @else
                    bg-gray-200 text-gray-700
                @endif
            ">
                {{ ucfirst($rental->status) }}
            </span>
        </div>
        <div class="mb-2"><span class="font-semibold">Payment Status:</span>
            <span class="px-2 py-1 rounded text-xs
                @if($rental->payment_status === 'paid')
                    bg-green-200 text-green-900
                @elseif($rental->payment_status === 'refunded')
                    bg-yellow-200 text-yellow-900
                @else
                    bg-gray-200 text-gray-700
                @endif
            ">
                {{ ucfirst($rental->payment_status) }}
            </span>
        </div>
        <div class="mb-2"><span class="font-semibold">Base Cost:</span> {{ number_format($rental->base_cost, 2) }} KES</div>
        @if($rental->driver_requested)
            <div class="mb-2"><span class="font-semibold">Driver Requested:</span> Yes</div>
            <div class="mb-2"><span class="font-semibold">Driver Cost:</span> {{ number_format($rental->driver_cost, 2) }} KES</div>
        @endif
        <div class="mb-2 font-bold text-green-800"><span class="font-semibold">Total Cost:</span> {{ number_format($rental->total_cost, 2) }} KES</div>
        <div class="mb-2"><span class="font-semibold">Notes:</span> {{ $rental->notes ?? '-' }}</div>
        <div class="mb-2"><span class="font-semibold">Created At:</span> {{ $rental->created_at->format('M d, Y H:i') }}</div>
    </div>
</div>
@endsection