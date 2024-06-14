<?php

namespace App\Http\Controllers;

use App\Models\Myfile;
use App\Models\Logevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MyfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('listMyfiles', [
            'myfiles' => Myfile::latest()->get()
        ]);
    }
    public function create()
    {

        return view('createMyfile');

    }



    public function store(Request $request)
    {

        $formFields = $request->validate([
            'myfile' => 'required|max:2000',
            'comment' => 'required',
        ]);
        $myfilereq = $request->file('myfile');
        try {


            if ($request->hasFile('myfile')) {

                $myfile = Myfile::create([
                    'user_id' => Auth::user()->id,
                    'comment' => $request->get('comment'),
                    'original_name' => $myfilereq->getClientOriginalName(),
                    'file' => $myfilereq->store('/common/files', ['disk' => 'spaces', 'visibility' => 'public']),
                    // 'file' => $myfilereq->store('files', 'public'),


                ]);
            }

        } catch (QueryException $exception) {
            $errorInfo = json_encode($exception->getMessage());
            return redirect('newsupplier')->with('message', $errorInfo);
        }
        $mymessage = "Archivo Registrado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$myfile->id}) Nombre ({$myfile->original_name}) Descripcion ({$myfile->comment}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/myfiles')->with('message', 'Archivo registrado');
    }
    /**
     * Display the specified resource.
     */
    public function show(Myfile $myfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Myfile $myfile)
    {
        return view('editMyfile', [
            'myfile' => $myfile
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Myfile $myfile)
    {
        $formFields = $request->validate([
            'comment' => 'required',
        ]);

        try {
            $myfile->update($formFields);
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/myfiles')->with('message', $errorInfo);
        }

        $mymessage = "Archivo Actualizado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$myfile->id}) Nombre ({$myfile->original_name}) Descripcion ({$myfile->comment}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/myfiles')->with('message', 'Archivo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Myfile $myfile)
    {
        try {
            $myfile->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/myfiles')->with('message', $errorInfo);
        }
        $mymessage = "Archivo Eliminado por el Usuario: ID (" . Auth::user()->id . ")  Nombre (" . Auth::user()->name . ") | ID ({$myfile->id}) Nombre ({$myfile->original_name}) Descripcion ({$myfile->comment}) ";
        Log::info($mymessage);
        Logevent::create([
            'event' => $mymessage,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/myfiles')->with('message', 'Archivo eliminado');
    }
}
