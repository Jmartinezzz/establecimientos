<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
        	'nombre' => 'Restaurante',
        	'slug' => Str::slug('Restaurantes'),        	
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('categorias')->insert([
        	'nombre' => 'Café',
        	'slug' => Str::slug('Cafés'),        	
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('categorias')->insert([
        	'nombre' => 'Hotel',
        	'slug' => Str::slug('Hoteles'),        	
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('categorias')->insert([
        	'nombre' => 'Bar',
        	'slug' => Str::slug('Bares'),        	
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('categorias')->insert([
        	'nombre' => 'Hospital',
        	'slug' => Str::slug('Hospitales'),        	
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('categorias')->insert([
        	'nombre' => 'Doctor',
        	'slug' => Str::slug('Doctores'),        	
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);
    }
}
