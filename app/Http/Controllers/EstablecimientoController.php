<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use App\Models\Categoria;
use App\Models\Imagen;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\EstablecimientosRequest;

class EstablecimientoController extends Controller
{
    public function __construct(){
        $this->middleware('revisarEstablecimiento')->only('create');
    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::pluck('nombre','id');
        return view('establecimientos.create', ['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstablecimientosRequest $eRequest)
    {

        $ruta_imagen = $eRequest->imagen_principal->store('principales', 'public');
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 600);
        $img->save();

        $establecimiento = new Establecimiento($eRequest->all());
        $establecimiento->img_principal = $ruta_imagen;
        $establecimiento->categoria_id = $eRequest->categoria;
        $establecimiento->user_id = auth()->user()->id;        
        $establecimiento->save();

        // auth()->user()->establecimiento()->create([
        //     'nombre' => $eRequest->nombre,
        //     'categoria' => $eRequest->categoria,
        //     'imagen_principal' => $eRequest->imagen_principal,
        //     'direccion' => $eRequest->direccion,
        //     'colonia' => $eRequest->colonia,
        //     'lat' => $eRequest->lat,
        //     'lng' => $eRequest->lng,
        //     'telefono' => $eRequest->telefono,
        //     'descripcion' => $eRequest->descripcion,
        //     'apertura' => $eRequest->apertura,
        //     'cierre' => $eRequest->cierre,
        //     'uuid' => $eRequest->uuid,
        // ]);//otra forma de almacenar
        return back()->with('estado','Tu establecimiento se almacenó correctamente 👍');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {        
        $this->authorize('update', $establecimiento);
    	$categorias = Categoria::pluck('nombre','id');
    	//$establecimiento = auth()->user()->establecimiento;        

    	$establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura));
    	$establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre));

    	//obtener las imagenes del establecimiento
    	$imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();
        return view('establecimientos.edit', [
        	'categorias' => $categorias, 
        	'establecimiento' => $establecimiento,
        	'imagenes' => $imagenes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(EstablecimientosRequest $eRequest, Establecimiento $establecimiento)
    {
         $this->authorize('update', $establecimiento);

        $establecimiento->nombre = $eRequest->nombre;
		$establecimiento->categoria_id = $eRequest->categoria;
		$establecimiento->direccion = $eRequest->direccion;
		$establecimiento->colonia = $eRequest->colonia;
		$establecimiento->lat = $eRequest->lat;
		$establecimiento->lng = $eRequest->lng;
		$establecimiento->telefono = $eRequest->telefono;
		$establecimiento->descripcion = $eRequest->descripcion;
		$establecimiento->apertura = $eRequest->apertura;
		$establecimiento->cierre = $eRequest->cierre;

		if (request('imagen_principal')) {
			File::delete('storage/' . $establecimiento->img_principal);
			$ruta_imagen = $eRequest->imagen_principal->store('principales', 'public');
        	$img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 600);
        	$img->save();

        	$establecimiento->img_principal = $ruta_imagen;
		}
		$establecimiento->save();
		return back()->with('estado','Tu establecimiento se actualizó correctamente 👍');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
