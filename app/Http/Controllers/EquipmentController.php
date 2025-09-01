<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\EquipmentService;
use App\Models\{User,Equipment,EquipmentCategory};
class EquipmentController extends Controller
{

    //
    protected $equipmentservice;

    public function __construct(EquipmentService  $equipmentservice)
    {
        $this->equipmentservice = $equipmentservice;
    }

    public function index()
    {
        // Business logic in the service
        
        if(Auth::user())
        {
            $user = Auth::user();
        }

       // $user = User::find(25);

        $equipment = $this->equipmentservice->getOwnedEquipment($user);
        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        $categories = EquipmentCategory::all();
        return view('equipment.create',['categories' => $categories]);
    }

    public function show(Equipment $equipment)
    {
        $equipment->load('category', 'rentals.farmer');
    
        return view('equipment.show', compact('equipment'));
    }
 
    public function store(Request $request)
    {
        $user = User::find(1);

        if($request->user())
        {
            $user = $request->user();
        }

        // Only handle validation for field types and required-ness.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:equipment_categories,id',
            'hourly_rate' => 'nullable|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'includes_driver' => 'required|boolean',
            'driver_additional_cost' => 'nullable|numeric|min:0',
            'availability_status' => 'required|in:available,rented,maintenance',
            'location' => 'nullable|string|max:255',
            'image' => 'required',
        ]);

        // Delegate business logic to the service
        $validated + ['image' => $request->file('image')];
        $this->equipmentservice->createEquipment($validated, $user);

        return back()->with('success', 'Equipment added successfully!');
    }

    public function queryEquipment(Request $request)
    {

        $equipmentName = $request->query('equipmentName');

        $equipment = $this->equipmentservice->queryEquipment($equipmentName);

        return view('equipment.searchResults',compact('equipment'));
        
    }

}
