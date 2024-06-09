<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Logevent;
use App\Models\Property;
use App\Models\Subproperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class SubpropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listSubproperties', [
            'subproperties' => Subproperty::latest()->get()

        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createSubproperty', [
            'landlords' => Landlord::all(),
            'properties' => Property::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'property_id' => 'required',
            'landlord_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'typed' => 'required',
            'rent' => 'required',
            'address' => 'required',
            'description' => 'required',
        ]);


        $mytype = $request->get('typed');
        $mydescription = $request->get('description');

        $formFields = array_merge($formFields, array('description' => $mydescription . '&&&' . $mytype));


        try {
            $subproperty = Subproperty::create($formFields);


        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newsubproperty')->with('message', $errorInfo);
        }

        $mymessage = "Subnidad Creada por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$subproperty->id}) Nombre ({$subproperty->title}) Tipo ({$subproperty->type}) Direccion ({$subproperty->address}) Descripcion ({$subproperty->description}) Propietario Asociado ({$subproperty->landlord_id}) Propiedad Asociada ({$subproperty->property_id}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/subproperties')->with('message', 'Subunidad creada');
    }


    /**
     * Display the specified resource.
     */
    public function show(Subproperty $subproperty)
    {

        return view('showSubproperty', [
            'subproperty' => $subproperty
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subproperty $subproperty)
    {
        return view('editSubproperty', [
            'subproperty' => $subproperty,
            'landlords' => Landlord::all(),
            'properties' => Property::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subproperty $subproperty)
    {
        $formFields = $request->validate([
            'property_id' => 'required',
            'landlord_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'typed' => 'required',
            'rent' => 'required',
            'address' => 'required',
            'description' => 'required',
        ]);

        $mytype = $request->get('typed');
        $mydescription = $request->get('description');

        $formFields = array_merge($formFields, array('description' => $mydescription . '&&&' . $mytype));

        try {
            $subproperty->update($formFields);


        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newsubproperty')->with('message', $errorInfo);
        }

        $mymessage = "Subnidad Actualizada por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$subproperty->id}) Nombre ({$subproperty->title}) Tipo ({$subproperty->type}) Direccion ({$subproperty->address}) Descripcion ({$subproperty->description}) Propietario Asociado ({$subproperty->landlord_id}) Propiedad Asociada ({$subproperty->property_id}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/subproperties')->with('message', 'Subunidad actualizada');

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subproperty $subproperty)
    {
        try {
            $subproperty->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/subproperties')->with('message', $errorInfo);
        }

        $mymessage = "Subnidad Eliminada por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$subproperty->id}) Nombre ({$subproperty->title}) Tipo ({$subproperty->type}) Direccion ({$subproperty->address}) Descripcion ({$subproperty->description}) Propietario Asociado ({$subproperty->landlord_id}) Propiedad Asociada ({$subproperty->property_id}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/subproperties')->with('message', 'Subunidad eliminada');

    }


}
