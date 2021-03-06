<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Establecimiento;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ImagenController extends Controller
{
    public function store(Request $request)
    {    	

    	$ruta_imagen =$request->file('file')->store('establecimientos', 'public'); //si usas store hay que crear el enlace simbolico storage:link
    	//resize
    	$imagen = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 450);
    	$imagen->save();

    	//almacenar con modelo
    	$imagenDB = new Imagen;
    	$imagenDB->id_establecimiento = $request->uuid;
    	
    	$imagenDB->ruta = $ruta_imagen;

    	$imagenDB->save();
    	$respuesta = [
    		'archivo' => $ruta_imagen
    	];

    	return response()->json($respuesta);
    }

    public function destroy(Request $request)
    {
        $imagen = $request->imagen; //viene de los params de la peticion axios
    	$uuid = $request->uuid; //viene de los params de la peticion axios
        $establecimiento = Establecimiento::where('uuid', $uuid)->first();
        $this->authorize('delete', $establecimiento); //validamos que el usuario sea el propietario
    	if (File::exists('storage/' . $imagen)) {
            // eliminar del servidor
    		File::delete('storage/' . $imagen);

            // elimina del servidor
    		Imagen::where('ruta', $imagen)->delete();

            $respuesta = [
            'mensaje' => 'Imagen Eliminada',
            'imagen' => $imagen
            ];

    	}
    
    	return response()->json($respuesta);
    }
}
