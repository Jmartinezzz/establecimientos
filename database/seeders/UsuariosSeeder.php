<?php

namespace Database\Seeders;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => 'Jorge',
        	'email' => 'correo@correo.com',
        	'email_verified_at' => Carbon::now(),
        	'password' => Hash::make('secret'),
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
        	'name' => 'Alberto',
        	'email' => 'correo2@correo.com',
        	'email_verified_at' => Carbon::now(),
        	'password' => Hash::make('secret'),
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Doral',
            'email' => 'correo3@correo.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Isidro',
            'email' => 'correo4@correo.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Condorado',
            'email' => 'correo5@correo.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
