<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RentalService;
use App\Models\{User,Rental};

class RentalController extends Controller
{

    //

    protected $rentalservice;

    public function __construct(RentalService $rentalservice)
    {
        $this->rentalservice = $rentalservice;
    }

    public function rentalRequests()
    {

        $user = Auth::user();

        $requestedRentals = $this->rentalservice->getRentalRequests($user);

        return view('rentals.requests',compact('requestedRentals'));


    }


    public function dashboard()
    {
        $user = User::find(1);
        if(Auth::user())
        {
            $user = Auth::user();
        }
       
    
        $data = $this->rentalservice->getDashboardData($user);
   
        return view('rentals.dashboard', $data);
    }


    public function show(Rental $rental)
    {
        $rental->load('equipment.category', 'owner', 'farmer');
        return view('rentals.show', compact('rental'));
    }

    public function index()
    {
         //$user = User::find(1);
        if(Auth::user())
        {
            $user = Auth::user();
        }

        $myRentals = $this->rentalservice->getMyRentals($user);

        return view('rentals.index', compact('myRentals')); // Pass as array, not single key 'data'

    }

    public function leasedEquipment()
    {

        $user = Auth::user();

        $leasedEquipments  = $this->rentalservice->getLeasedEquipment($user);
        
        return view('rentals.leased',compact('leasedEquipments'));

    }

    public function store(Request $request)
    {

        $user = $request->user();

        $equipment = $request->validate([
            'equipment_id' => ['required'],
            'duration' => ['required'],
            'rental_type' => ['required']
        ]);

        

        $status = $this->rentalservice->rentEquipment($user,$equipment);

        if($status)
        {
            return redirect()->back()->with('message','Equipment requested');
        }

        return redirect()->back()->with('message','cannot request equipment');



    }

    public function updateStatus(Request $request,Rental $rental)
    {


        if (auth()->id() !== $rental->owner_id) {
            abort(403);
        }
    
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,active,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,refunded'
        ]);
    
        $rental->update($validated);
    
        return back()->with('message', 'Rental status updated.');
    

    }

}
