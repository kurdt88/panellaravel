<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class LandlordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listLandlords', [
            'landlords' => Landlord::orderBy('id', 'desc')->get()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createLandlord', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'comment' => 'required',
        ]);


        try {
            $landlord = Landlord::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newlandlord')->with('message', $errorInfo);
        }

        Log::info("Propietario Creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$landlord->id}) Nombre ({$landlord->name}) Email ({$landlord->email}) Telefono ({$landlord->phone}) Direccion ({$landlord->address}) Comentario ({$landlord->comment})");

        return redirect('/landlords')->with('message', 'Propietario creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Landlord $landlord)
    {
        return view('showLandlord', [
            'landlord' => $landlord
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Landlord $landlord)
    {
        return view('editLandlord', [
            'landlord' => $landlord
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Landlord $landlord)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'comment' => 'required',
        ]);



        try {
            $landlord->update($formFields);


        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newlandlord')->with('message', $errorInfo);
        }

        Log::info("Propietario Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$landlord->id}) Nombre ({$landlord->name}) Email ({$landlord->email}) Telefono ({$landlord->phone}) Direccion ({$landlord->address}) Comentario ({$landlord->comment})");

        return redirect('/landlords')->with('message', 'Propietario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Landlord $landlord)
    {
        try {
            $landlord->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('landlords')->with('message', $errorInfo);
        }

        Log::info("Propietario Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$landlord->id}) Nombre ({$landlord->name}) Email ({$landlord->email}) Telefono ({$landlord->phone}) Direccion ({$landlord->address}) Comentario ({$landlord->comment})");

        return redirect('/landlords')->with('message', 'Propietario eliminado');
    }

    public function showItems(Landlord $landlord)
    {
        return view('showLandlordItems', [
            'landlord' => $landlord
        ]);
    }
}
