<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use Illuminate\Http\Request;

class AmbienteController extends Controller
{
    /**
     * Mostrar todos los ambientes.
     */
    public function index()
    {
        $ambientes = Ambiente::all();
        return view('encargado.ambientes', compact('ambientes'));
    }

    /**
     * Mostrar el formulario para crear un nuevo ambiente.
     */
    public function create()
    {
        return view('encargado.create');
    }

    /**
     * Guardar un nuevo ambiente en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada, incluyendo el rango de horarios
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'required|string|max:1000',
            'available_from' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $time = \Carbon\Carbon::createFromFormat('H:i', $value);
                    if ($time->hour < 8 || $time->hour >= 20) {
                        $fail('El horario de apertura debe estar entre 08:00 AM y 08:00 PM.');
                    }
                }
            ],
            'available_until' => [
                'required',
                'date_format:H:i',
                'after:available_from',
                function ($attribute, $value, $fail) {
                    $time = \Carbon\Carbon::createFromFormat('H:i', $value);
                    if ($time->hour < 8 || $time->hour > 20) {
                        $fail('El horario de cierre debe estar entre 08:00 AM y 08:00 PM.');
                    }
                }
            ],
            'description' => 'nullable|string|max:500' // Agregar campo de descripción opcional
        ]);

        // Crear el nuevo ambiente
        Ambiente::create($request->all());

        return redirect()->route('ambientes.index')->with('success', 'Ambiente creado correctamente.');
    }

    /**
     * Mostrar el formulario para editar un ambiente existente.
     */
    public function edit($id)
    {
        $ambiente = Ambiente::findOrFail($id);
        return view('encargado.edit', compact('ambiente'));
    }

    /**
     * Actualizar un ambiente en la base de datos.
     */

     public function update(Request $request, $id)
{
    // Validar los datos de entrada
    $request->validate([
        'name' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'description' => 'nullable|string|max:1000',
        'available_from' => [
            'nullable',
            'date_format:H:i',
            function ($attribute, $value, $fail) {
                if ($value) {
                    $time = \Carbon\Carbon::createFromFormat('H:i', $value);
                    if ($time->hour < 8 || $time->hour >= 20) {
                        $fail('El horario de apertura debe estar entre 08:00 AM y 08:00 PM.');
                    }
                }
            }
        ],
        'available_until' => [
            'nullable',
            'date_format:H:i',
            'after:available_from',
            function ($attribute, $value, $fail) {
                if ($value) {
                    $time = \Carbon\Carbon::createFromFormat('H:i', $value);
                    if ($time->hour < 8 || $time->hour > 20) {
                        $fail('El horario de cierre debe estar entre 08:00 AM y 08:00 PM.');
                    }
                }
            }
        ],
    ]);

    // Buscar y actualizar el ambiente
    $ambiente = Ambiente::findOrFail($id);

    // Si no se proporciona una nueva hora, se mantienen las horas actuales
    $data = $request->all();
    $data['available_from'] = $request->available_from ?: $ambiente->available_from;
    $data['available_until'] = $request->available_until ?: $ambiente->available_until;

    // Actualiza los campos
    $ambiente->update($data);

    return redirect()->route('ambientes.index')->with('success', 'Ambiente actualizado correctamente.');
}

    /**
     * Eliminar un ambiente de la base de datos.
     */
    public function destroy($id)
    {
        $ambiente = Ambiente::findOrFail($id);
        $ambiente->delete();

        return redirect()->route('ambientes.index')->with('success', 'Ambiente eliminado correctamente.');
    }
}
