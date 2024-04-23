<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [

        ]);


    }


    public function welcome()
    {

        $resultados = Payment::select('type', DB::raw('sum(ammount) as total'))
            ->groupBy('type')
            // ->orderBy('total')
            ->get();

        // $resultados2 = Payment::select('concept', DB::raw('sum(ammount) as total'))
        //     ->groupBy('concept')
        //     ->get();

        return view('bienvenido', [
            'leases' => Lease::latest()->get(),
            'properties' => Property::latest()->get(),
            'payments' => Payment::latest()->get(),
            'tenants' => Tenant::latest()->get(),
            'resultados' => $resultados
            // 'resultados2' => $resultados2

        ]);
    }

    public function settings()
    {
        return view('showProfile');
    }
}
