<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    use HasFactory;

    protected $fillable = [
    	'categoria_id',
    	'user_id',
		'nombre',
		'img_principal',
		'direccion',
		'colonia',
		'lat',
		'lng',
		'telefono',
		'descripcion',
		'apertura',
		'cierre',
		'uuid'
	];

	public function categoria(){
		return $this->belongsTo(Categoria::class);
	}
}
