@extends('rentals.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-green-700">My Requested Equipment</h2>
    </div>

    @if(session('message'))
        <div class="mb-6">
            <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded">
                {{ session('message') }}
            </div>
        </div>
    @endif

    @if($requestedRentals->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-green-200 rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Equipment</th>
                        <th class="py-2 px-3 text-left">Requested by</th>
                        <th class="py-2 px-3 text-left">Duration </th>
                        <th class="py-2 px-3 text-left">Requested On</th>
                        <th class="py-2 px-3 text-left">Status</th>
                        <th class="py-2 px-3 text-left">Total Cost</th>
                        <th class="py-2 px-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestedRentals as $rental)
                        <tr class="border-t border-green-100">
                            <td class="py-2 px-3 flex items-center gap-2">
                                @php
                                    $defaultImage = "https://pxhere.com/en/photo/179861";
                                    $firstImage = $rental->equipment->images[0] ?? null;
                                @endphp
                                <img src="{{ asset('storage/' . $rental->equipment->image) }}" alt="" class="w-10 h-10 object-cover rounded mr-2">
                                <span>{{ $rental->equipment->name }}</span>
                            </td>
                            <td class="py-2 px-3 text-capitalize">
                                {{ $rental->farmer->name }}
                            </td>
                            <td class="py-2 px-3">
                                {{ $rental->duration_hours ?? '-' }}
                                
                            </td>
                            <td class="py-2 px-3">
                                {{ \Carbon\Carbon::parse($rental->created_at)->format('M d, Y H:i') }}
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($rental->status === 'pending')
                                        bg-yellow-200 text-yellow-900
                                    @elseif($rental->status === 'confirmed' || $rental->status === 'active')
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
                                <a href="{{ route('rentals.show', $rental->id) }}" class="text-green-700 hover:underline font-semibold">
                                    View Details
                                </a>
                                {{-- You can add Cancel or other actions here if needed --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert bg-green-50 text-green-800 p-4 rounded">
            You have no requested equipment.
        </div>
    @endif
</div>
@endsection