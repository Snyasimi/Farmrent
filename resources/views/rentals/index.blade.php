@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-green-700">My Active Rentals</h2>
        <div class="flex gap-3">
            <a href="{{ route('rentEquipment') }}"
                class="inline-block bg-green-700 text-white px-4 py-2 rounded font-semibold hover:bg-green-800 transition">
                Rent New Equipment
            </a>
            <a href="{{ route('leasedEquipment') }}"
                class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded font-semibold border border-green-400 hover:bg-green-200 transition">
                Leased Equipment
            </a>
        </div>
    </div>

    @if($myRentals->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Equipment</th>
                        <th class="py-2 px-3 text-left">Rental Period</th>
                        <th class="py-2 px-3 text-left">Duration</th>
                        <th class="py-2 px-3 text-left">Driver</th>
                        <th class="py-2 px-3 text-left">Total Cost</th>
                        <th class="py-2 px-3 text-left">Payment</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myRentals as $rental)
                     
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3 flex items-center gap-2">
                                <img src="{{ asset('storage/' . $rental->equipment->image)  }}" alt="" class="w-16 h-16 object-cover rounded mr-2">
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