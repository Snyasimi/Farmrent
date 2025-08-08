@extends('user.layout')

@section('title', 'Farmer Dashboard')

@section('content')
<div class="min-h-screen bg-green-50 p-8">
    <div class="container mx-auto">
        <!-- Welcome message for the logged-in farmer -->
        <h1 class="text-3xl font-bold text-green-700 mb-6">Welcome, {{ Auth::user()->name ?? 'Farmer' }}!</h1>

        <!-- Section: Quick Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded shadow p-4 text-center">
                <h2 class="text-lg font-bold text-green-700">Your Equipment</h2>
                <!-- Total count of equipment owned by the farmer -->
                <p class="text-2xl font-bold text-gray-800">{{ $ownedEquipmentCount ?? 0 }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <h2 class="text-lg font-bold text-green-700">Available Equipment for Rent</h2>
                <!-- Total count of equipment available for rent -->
                <p class="text-2xl font-bold text-gray-800">{{ $availableEquipmentCount ?? 0 }}</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <h2 class="text-lg font-bold text-green-700">Pending Rentals</h2>
                <!-- Total count of rentals that are pending -->
                <p class="text-2xl font-bold text-gray-800">{{ $pendingRentalsCount ?? 0 }}</p>
            </div>
        </div>

        <!-- Section: Your Equipment -->
        <div class="bg-white rounded shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-green-700 mb-4">Your Equipment</h2>
            @if(!empty($ownedEquipment) && $ownedEquipment->isEmpty())
                <!-- Message if the farmer has no equipment listed -->
                <p class="text-gray-600">You don't have any equipment listed yet. <a href="{{ route('equipment.create') }}" class="text-green-700 font-bold hover:underline">Add Equipment</a></p>
            @else
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-green-100">
                            <th class="border p-2 text-left">Name</th>
                            <th class="border p-2 text-left">Category</th>
                            <th class="border p-2 text-left">Price Per Day</th>
                            <th class="border p-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through all equipment owned by the farmer -->
                        @foreach($ownedEquipment ?? [] as $equipment)
                        <tr>
                            <!-- Name of the equipment -->
                            <td class="border p-2">{{ $equipment->name ?? 'N/A' }}</td>
                            <!-- Category of the equipment (if available) -->
                            <td class="border p-2">{{ $equipment->category->name ?? 'Uncategorized' }}</td>
                            <!-- Price per day for renting the equipment -->
                            <td class="border p-2">${{ number_format($equipment->price_per_day ?? 0, 2) }}</td>
                            <!-- Availability status of the equipment -->
                            <td class="border p-2">{{ $equipment->availability_status ? 'Available' : 'Rented' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Section: Rental Activities -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold text-green-700 mb-4">Recent Rental Activities</h2>
            @if(!empty($recentRentals) && $recentRentals->isEmpty())
                <!-- Message if there are no recent rental activities -->
                <p class="text-gray-600">No recent rental activities.</p>
            @else
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-green-100">
                            <th class="border p-2 text-left">Equipment</th>
                            <th class="border p-2 text-left">Renter</th>
                            <th class="border p-2 text-left">Start Date</th>
                            <th class="border p-2 text-left">End Date</th>
                            <th class="border p-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through all recent rental activities -->
                        @foreach($recentRentals ?? [] as $rental)
                        <tr>
                            <!-- Name of the rented equipment -->
                            <td class="border p-2">{{ $rental->equipment->name ?? 'N/A' }}</td>
                            <!-- Name of the user who rented the equipment -->
                            <td class="border p-2">{{ $rental->user->name ?? 'N/A' }}</td>
                            <!-- Rental start date -->
                            <td class="border p-2">{{ $rental->rental_start_date ?? 'N/A' }}</td>
                            <!-- Rental end date -->
                            <td class="border p-2">{{ $rental->rental_end_date ?? 'N/A' }}</td>
                            <!-- Status of the rental (e.g., pending, active, completed) -->
                            <td class="border p-2">{{ ucfirst($rental->status ?? 'unknown') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection