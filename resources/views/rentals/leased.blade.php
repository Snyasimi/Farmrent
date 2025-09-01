@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-green-700">My Leased Equipment</h2>
            <p class="text-gray-600 mt-2">
                Here you can view all equipment that you have leased out to other users.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('rentals.index') }}"
                class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded font-semibold border border-green-400 hover:bg-green-200 transition">
                Active Rentals
            </a>
        </div>
    </div>

    @if($leasedEquipments->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Equipment</th>
                        <th class="py-2 px-3 text-left">Rented By</th>
                        <th class="py-2 px-3 text-left">Rental Period</th>
                        <th class="py-2 px-3 text-left">Duration (hrs)</th>
                        <th class="py-2 px-3 text-left">Driver</th>
                        <th class="py-2 px-3 text-left">Total Cost</th>
                        <th class="py-2 px-3 text-left">Status</th>
                        <th class="py-2 px-3 text-left">Payment</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leasedEquipments as $lease)
                        @php
                            $defaultImage = "https://pxhere.com/en/photo/179861";
                            $firstImage = $lease->equipment->images[0] ?? null;
                        @endphp
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3 flex items-center gap-2">
                                <img src="{{ asset('storage/' . $lease->equipment->image) }}" alt="" class="w-16 h-16 object-cover rounded mr-2">
                                <span>{{ $lease->equipment->name }}</span>
                            </td>
                            <td class="py-2 px-3">
                                {{ $lease->farmer->name ?? 'N/A' }}
                            </td>
                            <td class="py-2 px-3">
                                {{ \Carbon\Carbon::parse($lease->rental_start_datetime)->format('M d, Y') }}
                                -
                                {{ \Carbon\Carbon::parse($lease->rental_end_datetime)->format('M d, Y') }}
                            </td>
                            <td class="py-2 px-3">
                                {{ $lease->duration_hours }}
                            </td>
                            <td class="py-2 px-3">
                                @if($lease->driver_requested)
                                    <span class="inline-block px-2 py-1 bg-green-200 text-green-900 rounded text-xs">Yes</span>
                                    @if($lease->driver_cost)
                                        <div class="text-xs text-green-700">+KES {{ number_format($lease->driver_cost, 2) }}</div>
                                    @endif
                                @else
                                    <span class="inline-block px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">No</span>
                                @endif
                            </td>
                            <td class="py-2 px-3">
                                {{ number_format($lease->total_cost, 2) }} KES
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($lease->status === 'active' || $lease->status === 'confirmed')
                                        bg-green-200 text-green-900
                                    @elseif($lease->status === 'completed')
                                        bg-blue-200 text-blue-900
                                    @elseif($lease->status === 'cancelled')
                                        bg-red-200 text-red-900
                                    @else
                                        bg-gray-200 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($lease->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($lease->payment_status === 'paid')
                                        bg-green-200 text-green-900
                                    @elseif($lease->payment_status === 'refunded')
                                        bg-blue-200 text-blue-900
                                    @else
                                        bg-gray-200 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($lease->payment_status) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                <a href="{{ route('rentals.show', $lease->id) }}" class="text-green-700 hover:underline font-semibold">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded">You have no leased equipment.</div>
    @endif
</div>
@endsection