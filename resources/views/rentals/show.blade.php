@extends('rentals.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-green-700">Rental Details</h2>
        <a href="{{ route('rentals.index') }}" class="text-green-700 hover:underline">&larr; Back to My Rentals</a>
    </div>

    <div class="bg-white rounded shadow p-6 mb-8">
        <div class="flex gap-8 items-start">
          
            <img src="{{ asset('storage/'. $rental->equipment->image) }}" alt="{{ $rental->equipment->name }}" class="w-28 h-28 object-cover rounded">
            <div>
                <div class="mb-2"><span class="font-semibold">Equipment:</span>
                    <a href="{{ route('equipment.show', $rental->equipment->id) }}" class="text-green-700 hover:underline">{{ $rental->equipment->name }}</a>
                </div>
                <div class="mb-2"><span class="font-semibold">Category:</span> {{ $rental->equipment->category->name ?? 'N/A' }}</div>
                <div class="mb-2"><span class="font-semibold">Location:</span> {{ $rental->equipment->location ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Owner:</span> {{ $rental->owner->name ?? 'N/A' }}</div>
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

    {{-- Owner controls: Only show if the currently authenticated user owns the equipment --}}
    @if(auth()->id() === $rental->owner_id)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-8 mb-8">
            <h3 class="text-xl font-bold text-yellow-700 mb-4">Manage Rental Status</h3>
            <form action="{{ route('rentals.updateStatus', $rental->id) }}" method="POST" class="flex flex-col md:flex-row md:items-end gap-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="block text-gray-700 font-semibold mb-1">Change Status</label>
                    <select name="status" id="status" required class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-yellow-600">
                        <option value="pending" {{ $rental->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $rental->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="active" {{ $rental->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $rental->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $rental->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label for="payment_status" class="block text-gray-700 font-semibold mb-1">Change Payment Status</label>
                    <select name="payment_status" id="payment_status" required class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-yellow-600">
                        <option value="pending" {{ $rental->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $rental->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="refunded" {{ $rental->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded font-semibold hover:bg-yellow-700 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
@endsection