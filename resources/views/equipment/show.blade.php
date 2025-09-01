@extends('rentals.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-green-700">{{ $equipment->name }}</h2>
        <a href="{{ route('equipment.index') }}" class="text-green-700 hover:underline">&larr; Back to My Equipment</a>
    </div>

    {{-- Display success or error message --}}
    @if(session('message'))
        <div class="mb-6">
            <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded">
                {{ session('message') }}
            </div>
        </div>
    @endif

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
                
                {{-- Booking Request Form/Button --}}
                <div class="mt-4">
                    @if($equipment->availability_status === 'available')
                    <form action="{{ route('rentals.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
                        <div class="mb-4">
                            <label for="rental_type" class="block text-gray-700 font-semibold mb-1">Renting Style</label>
                            <select name="rental_type" id="rental_type" required class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="" disabled selected>Select rental style</option>
                                <option value="hourly">Hourly</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="duration" class="block text-gray-700 font-semibold mb-1">Duration</label>
                            <input
                                type="number"
                                min="1"
                                name="duration"
                                id="duration"
                                required
                                class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-600"
                                placeholder="Enter duration (number of hours/days/weeks)"
                            >
                            <small class="text-gray-500">Enter the number of units based on the selected renting style.</small>
                        </div>
                        <button type="submit"
                            class="bg-green-700 text-white px-6 py-2 rounded font-semibold hover:bg-green-800 transition">
                            Request to Book
                        </button>
                    </form>
                    @else
                        <button type="button"
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-semibold cursor-not-allowed"
                            disabled>
                            {{ ucfirst($equipment->availability_status) }}
                        </button>
                    @endif
                </div>
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