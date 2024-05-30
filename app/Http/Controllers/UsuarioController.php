<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

   

    public function activar($id)
        {
            $user = User::findOrFail($id);
            $user->activo = true;
            $user->save();

            return redirect()->back()->with('success', 'Usuario activado correctamente.');
        }

    public function desactivar($id)
        {
            $user = User::findOrFail($id);
            $user->activo = false;
            $user->save();

            return redirect()->back()->with('success', 'Usuario desactivado correctamente.');
        }
        
        
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->profile == 'admin') {
            $query = User::query();

            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                      ->orWhere('username', 'like', '%' . $request->search . '%');
            }
    
            $usuarios = $query->simplePaginate(10);
            return view('usuarios.GestionUsuarios', compact('usuarios'));
            
        } else {
            abort(403); 
        }
      
    }

    public function create()
    {
        return view('usuarios.CrearUsuarios');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile' => 'nullable|in:admin,cliente',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ];
    
        if ($request->has('profile')) {
            $userData['profile'] = $request->profile;
        }
    
        User::create($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito.');
    }

    public function show(User $usuario)
    {
        return view('usuarios.GestionUsuarios', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        return view('usuarios.EditarUsuarios', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile' => 'nullable|in:admin,cliente',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ];
        
        
        if ($request->has('profile')) {
            $userData['profile'] = $request->profile;
        }
        
        $usuario->update($userData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito.');
    }
}


