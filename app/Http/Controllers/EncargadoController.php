<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use Illuminate\Http\Request;

class EncargadoController extends Controller
{
    public function dashboard()
    {
        // Retorna la vista principal del encargado
        return view('encargado.dashboard');
    }

    public function manageAmbientes()
    {
        // Obtener todos los ambientes
        $ambientes = Ambiente::all();
        return view('encargado.ambientes', compact('ambientes'));
    }

    public function storeAmbiente(Request $request)
    {
        // Validar y guardar un nuevo ambiente
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
            'available_from' => 'required',
            'available_until' => 'required',
        ]);

        Ambiente::create($request->all());

        return redirect()->route('encargado.ambientes')->with('success', 'Ambiente creado con éxito.');
    }

    public function updateAmbiente(Request $request, $id)
    {
        // Validar y actualizar el ambiente existente
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
            'available_from' => 'required',
            'available_until' => 'required',
        ]);

        $ambiente = Ambiente::findOrFail($id);
        $ambiente->update($request->all());

        return redirect()->route('encargado.ambientes')->with('success', 'Ambiente actualizado con éxito.');
    }

    public function destroyAmbiente($id)
    {
        // Eliminar un ambiente
        $ambiente = Ambiente::findOrFail($id);
        $ambiente->delete();

        return redirect()->route('encargado.ambientes')->with('success', 'Ambiente eliminado con éxito.');
    }
}
