<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EquipmentService;

class HomePageController extends Controller
{
    //

    protected $equipmentservice;

    public function __construct(EquipmentService $equipmentservice)
    {
        $this->equipmentservice = $equipmentservice;
    }

    public function index()
    {
        return view('user.index');
    }

    public function listEquipment()
    {

        $equipment = $this->equipmentservice->getListedEquipment();

        return view('equipment.listing',compact('equipment'));

    }
}
