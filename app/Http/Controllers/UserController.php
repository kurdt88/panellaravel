<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('listUsers', [
            'users' => User::latest()->get()

        ]);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/users')->with('message', $errorInfo);
        }
        return redirect('/users')->with('message', 'Usuario eliminado');
    }

    public function edit(User $user)
    {
        return view('editUser', ['user' => $user]);
    }


    public function update(Request $request, User $user)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',

        ]);

        if ($password = $request->get('password')) {
            if ($password2 = $request->get('password2')) {
                if ($password == $password2) {
                    $formFields = array_merge($formFields, array('password' => bcrypt($password)));
                } else {
                    return Redirect::back()->withErrors([
                        'msg' => "Error. No coinciden los campos Cambiar Password y
                    Confirmar nuevo Password, intente de nuevo"
                    ]);
                }


            } else {
                return Redirect::back()->withErrors([
                    'msg' => "Error. Si desea cambiar el password del Usuario debe completar los campos Cambiar Password y
                Confirmar nuevo Password"
                ]);

            }

        }


        try {
            $user->update($formFields);
            if (($newrole = $request->get('role')) != 'sin asignar') {
                // dd($newrole);
                $user->assignRole($newrole);
            } else {

                if (count($user->getRoleNames()) > 0) {
                    foreach ($user->getRoleNames() as $role) {
                        $user->removeRole($role);
                    }

                }
            }

        } catch (QueryException $exception) {
            $errorInfo = $exception->getMessage();
            return redirect('/users')->with('message', $errorInfo);
        }

        return redirect('/users')->with('message', 'Usuario actualizado');
    }

}
