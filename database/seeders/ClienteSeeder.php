<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::truncate();

        $faker = Faker::create('es_EC');

        $items = [];
        $rucsUsados = [];

        for ($i = 0; $i < 30; $i++) {
            // RUC simple (13 dígitos) evitando duplicados
            do {
                $ruc = (string) $faker->numberBetween(1000000000000, 9999999999999);
            } while (isset($rucsUsados[$ruc]));
            $rucsUsados[$ruc] = true;

            $items[] = [
                'nombre' => $faker->name(),
                'ruc' => $ruc,
                'direccion' => $faker->streetAddress(),
                'ciudad' => $faker->city(),
                'telefono' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
            ];
        }

        Cliente::insert($items);
    }
}
