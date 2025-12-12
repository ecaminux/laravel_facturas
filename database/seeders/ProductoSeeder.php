<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::truncate();

        $nombresBase = [
            'Arroz', 'Azúcar', 'Café', 'Leche', 'Aceite', 'Atún', 'Pan', 'Queso',
            'Harina', 'Fideos', 'Sal', 'Jabón', 'Shampoo', 'Papel Higiénico',
            'Galletas', 'Cereal', 'Agua', 'Yogurt', 'Mantequilla', 'Chocolate',
        ];

        $items = [];
        for ($i = 0; $i < 40; $i++) {
            $nombre = $nombresBase[array_rand($nombresBase)] . ' ' . Str::upper(Str::random(3));

            $items[] = [
                'nombre' => $nombre,
                'stock' => random_int(20, 500),
                'precio_unitario' => round(mt_rand(50, 50000) / 100, 2), // 0.50 - 500.00
            ];
        }

        Producto::insert($items);
    }
}
