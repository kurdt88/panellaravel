<?php

namespace App\Http\Controllers;

use App\Models\Logevent;
use Illuminate\Http\Request;

class LogeventController extends Controller
{
    public function index()
    {

        return view('listEvents', [
            'logevents' => Logevent::latest()->get()

        ]);
    }
}
