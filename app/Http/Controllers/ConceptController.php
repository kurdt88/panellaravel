<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\Logevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\QueryException;
use App\Http\Requests\StoreConceptRequest;
use App\Http\Requests\UpdateConceptRequest;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listConcepts', [
            'concepts' => Concept::latest()->get()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createConcept', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);


        try {
            $concept = Concept::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newconcept')->with('message', $errorInfo);
        }


        $mymessage = "Concepto creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$concept->id}) Tipo ({$concept->type}) Concepto ({$concept->name})  ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/concepts')->with('message', 'Concepto creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Concept $concept)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concept $concept)
    {
        return view('editConcept', [
            'concept' => $concept
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Concept $concept)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);


        try {
            $concept->update($formFields);

        } catch (QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->getMessage();
            return redirect('newconcept')->with('message', $errorInfo);
        }

        $mymessage = "Concepto Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$concept->id}) Tipo ({$concept->type})  Nombre ({$concept->name})";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/concepts')->with('message', 'Concepto actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concept $concept)
    {
        try {
            $concept->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/concepts')->with('message', $errorInfo);
        }

        $mymessage = "Concepto Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$concept->id}) Nombre ({$concept->name}) Direccion ({$concept->address}) Descripcion ({$concept->description}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/concepts')->with('message', 'Concepto eliminado');
    }


}
