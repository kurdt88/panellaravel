<?php

namespace App\Http\Controllers;

use App\Models\Logevent;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listSuppliers', [
            'suppliers' => Supplier::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createSupplier', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'comment' => 'required',
        ]);

        if ($phone = $request->get('phone')) {
            $formFields = array_merge($formFields, array('phone' => $phone));
        }

        if ($email = $request->get('email')) {
            $formFields = array_merge($formFields, array('email' => $email));

        }

        try {
            $supplier = Supplier::create($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('newsupplier')->with('message', $errorInfo);
        }
        $mymessage = "Proveedor Creado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$supplier->id}) Nombre ({$supplier->name}) Descripcion ({$supplier->comment}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/suppliers')->with('message', 'Proveedor creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('showSupplier', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('editSupplier', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'comment' => 'required',
        ]);

        if ($phone = $request->get('phone')) {
            $formFields = array_merge($formFields, array('phone' => $phone));
        }

        if ($email = $request->get('email')) {
            $formFields = array_merge($formFields, array('email' => $email));

        }

        try {
            $supplier->update($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/suppliers')->with('message', $errorInfo);
        }

        $mymessage = "Proveedor Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$supplier->id}) Nombre ({$supplier->name}) Descripcion ({$supplier->comment}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/suppliers')->with('message', 'Proveedor actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/suppliers')->with('message', $errorInfo);
        }
        $mymessage = "Proveedor Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$supplier->id}) Nombre ({$supplier->name}) Descripcion ({$supplier->comment}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/suppliers')->with('message', 'Proveedor eliminado');
    }


    public function showPayments(Supplier $supplier)
    {

        return view('showSupplierPayments', [
            'supplier' => $supplier
        ]);
    }


}
