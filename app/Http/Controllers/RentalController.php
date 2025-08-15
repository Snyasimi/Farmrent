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
        $rental->load('equipment.category', 'renter', 'farmer');
        return view('rentals.show', compact('rental'));
    }

    public function index()
    {
         $user = User::find(1);
        if(Auth::user())
        {
            $user = Auth::user();
        }

        $myRentals = $this->rentalservice->getMyRentals($user);

        return view('rentals.index', compact('myRentals')); // Pass as array, not single key 'data'

    }
}
