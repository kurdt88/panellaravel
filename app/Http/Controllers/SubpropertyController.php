<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Property;
use App\Models\Subproperty;
use Illuminate\Http\Request;
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
            Subproperty::create($formFields);


        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newsubproperty')->with('message', $errorInfo);
        }

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
        return redirect('/subproperties')->with('message', 'Subunidad eliminada');

    }


}
