<?php

namespace App\Http\Controllers;

use App\Models\Inventarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class InventariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventario = Inventarios::all();
        return response()->json($inventario, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('Datos recibidos en la solicitud de creación:', $request->all());

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'codigo_producto' => 'required|string',
            'descripcion' => 'required|string',
            'cantidad_stock' => 'required|integer',
            'img_product' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'precio_producto' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $inventario_data = $request->all();

        // Procesar la imagen si se cargó
        if ($request->hasFile('img_product')) {
            $image = $request->file('img_product');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $image_name);
            $inventario_data['img_product'] = '/storage/images/' . $image_name;
        }

        $inventario = Inventarios::create($inventario_data);

        return response()->json($inventario, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventarios  $inventario
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $terminoBusqueda = $request->query('termino');
        $campoPrioridad = $request->query('campo'); // Obtén el campo de prioridad desde la solicitud

        $campos = ['product_name', 'codigo_producto', 'descripcion', 'id'];

        // Verifica si el campo de prioridad es válido
        if (in_array($campoPrioridad, $campos)) {
            $query = Inventarios::where($campoPrioridad, 'LIKE', "%{$terminoBusqueda}%");
        } else {
            // Si el campo no es válido, busca en todos los campos
            $query = Inventarios::query();
            foreach ($campos as $campo) {
                $query->orWhere($campo, 'LIKE', "%{$terminoBusqueda}%");
            }
        }

        $resultados = $query->get();

        return response()->json($resultados);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventarios  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventario_data = Inventarios::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'codigo_producto' => 'sometimes|string',
            'descripcion' => 'sometimes|string',
            'cantidad_stock' => 'sometimes|integer',
            'precio_producto' => 'sometimes|numeric',
            'img_product' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $validatedData = $validator->validated();
        if ($request->hasFile('img_product')) {
            if ($inventario_data->img_product) {
                Storage::delete('public/images/' . basename($inventario_data->img_product));
            }
            $image = $request->file('img_product');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $image_name);
            $validatedData['img_product'] = '/storage/images/' . $image_name;
        }
        $inventario_data->update($validatedData);

        return response()->json(['success' => true], 200);

    }
    public function updateStock(Request $request, $id)
    {

        $inventario_data = Inventarios::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'cantidad_stock' => 'sometimes|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $validatedData = $validator->validated();
        $inventario_data->update($validatedData);

        return response()->json(['success' => true], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventarios  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $inventario = Inventarios::findOrFail($id);
        $inventario->delete();
        return response()->json(['message' => 'Eliminado con éxito']);
    }
}

