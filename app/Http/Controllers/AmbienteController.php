<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function dashboard()
{
    $ambientes = Ambiente::all();
    return view('dashboard', compact('ambientes'));
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
            'description' => 'nullable|string|max:1000',
            'available_from' => 'required|date_format:H:i|after_or_equal:08:00|before:20:00',
            'available_until' => 'required|date_format:H:i|after:available_from|before_or_equal:20:00',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Valida solo si se envía una imagen
            'price' => 'required|numeric|min:0'
        ]);

        // Manejar la imagen si se ha subido
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Crear el nuevo ambiente con la ruta de la imagen
        Ambiente::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'available_from' => $request->available_from,
            'available_until' => $request->available_until,
            'image_path' => $imagePath,
            'price' => $request->price,
        ]);

        return redirect()->route('ambientes.index')->with('success', 'Ambiente creado correctamente.');
    }

    /**
     * Mostrar el formulario para editar un ambiente existente.
     */
    public function edit($id)
    {
        $ambiente = Ambiente::find($id);

        if (!$ambiente) {
            return redirect()->route('admin.ambientes')->withErrors('El ambiente no existe.');
        }

        return view('ambientes.edit', compact('ambiente'));
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
        'available_from' => 'nullable|date_format:H:i|after_or_equal:08:00|before:20:00',
        'available_until' => 'nullable|date_format:H:i|after:available_from|before_or_equal:20:00',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' => 'required|numeric|min:0',
    ]);

    // Buscar y actualizar el ambiente
    $ambiente = Ambiente::findOrFail($id);

    // Manejar la nueva imagen si se ha subido
    if ($request->hasFile('image')) {
        // Eliminar la imagen anterior si existe
        if ($ambiente->image_path && Storage::disk('public')->exists($ambiente->image_path)) {
            Storage::disk('public')->delete($ambiente->image_path);
        }

        // Almacenar la nueva imagen
        $imagePath = $request->file('image')->store('images', 'public');
        $ambiente->image_path = $imagePath; // Actualizamos el path de la imagen
    }

    // Actualizar los demás campos
    $ambiente->update([
        'name' => $request->name,
        'capacity' => $request->capacity,
        'description' => $request->description,
        'available_from' => $request->available_from ?: $ambiente->available_from,
        'available_until' => $request->available_until ?: $ambiente->available_until,
        'price' => $request->price,
    ]);

    // Redireccionar con un mensaje de éxito
    return redirect()->route('ambientes.index')->with('success', 'Ambiente actualizado correctamente.');
}

    /**
     * Eliminar un ambiente de la base de datos.
     */
    public function destroy($id)
    {
        $ambiente = Ambiente::findOrFail($id);

        // Eliminar la imagen si existe
        if ($ambiente->image_path && Storage::disk('public')->exists($ambiente->image_path)) {
            Storage::disk('public')->delete($ambiente->image_path);
        }

        // Eliminar el ambiente
        $ambiente->delete();

        return redirect()->route('ambientes.index')->with('success', 'Ambiente eliminado correctamente.');
    }
}
