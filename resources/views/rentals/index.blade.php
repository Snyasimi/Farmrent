@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-green-700">My Active Rentals</h2>
        <a href="{{ route('equipment.index') }}"
            class="inline-block bg-green-700 text-white px-4 py-2 rounded font-semibold hover:bg-green-800 transition">
            Rent New Equipment
        </a>
    </div>

    @if($myRentals->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Equipment</th>
                        <th class="py-2 px-3 text-left">Rental Period</th>
                        <th class="py-2 px-3 text-left">Duration (hrs)</th>
                        <th class="py-2 px-3 text-left">Driver</th>
                        <th class="py-2 px-3 text-left">Total Cost</th>
                        <th class="py-2 px-3 text-left">Payment</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myRentals as $rental)
                        @php
                            $defaultImage = "https://pxhere.com/en/photo/179861";
                            $firstImage = $rental->equipment->images[0] ?? null;
                        @endphp
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3 flex items-center gap-2">
                                <img src="{{ $firstImage ? asset('storage/' . $firstImage) : $defaultImage }}" alt="" class="w-10 h-10 object-cover rounded mr-2">
                                <span>{{ $rental->equipment->name }}</span>
                            </td>
                            <td class="py-2 px-3">
                                {{ \Carbon\Carbon::parse($rental->rental_start_datetime)->format('M d, Y') }}
                                -
                                {{ \Carbon\Carbon::parse($rental->rental_end_datetime)->format('M d, Y') }}
                            </td>
                            <td class="py-2 px-3">
                                {{ $rental->duration_hours }}
                            </td>
                            <td class="py-2 px-3">
                                @if($rental->driver_requested)
                                    <span class="inline-block px-2 py-1 bg-green-200 text-green-900 rounded text-xs">Yes</span>
                                    @if($rental->driver_cost)
                                        <div class="text-xs text-green-700">+KES {{ number_format($rental->driver_cost, 2) }}</div>
                                    @endif
                                @else
                                    <span class="inline-block px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">No</span>
                                @endif
                            </td>
                            <td class="py-2 px-3">
                                {{ number_format($rental->total_cost, 2) }} KES
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($rental->payment_status === 'paid')
                                        bg-green-200 text-green-900
                                    @elseif($rental->payment_status === 'refunded')
                                        bg-blue-200 text-blue-900
                                    @else
                                        bg-gray-200 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($rental->payment_status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                <a href="{{ route('rentals.show', $rental->id) }}" class="text-green-700 hover:underline font-semibold">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded">You have no active rentals.</div>
    @endif
</div>
@endsection