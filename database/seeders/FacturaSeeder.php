<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\DetalleFactura;

class FacturaSeeder extends Seeder
{
    public function run(): void
    {
        // Orden correcto por FK
        DetalleFactura::truncate();
        Factura::truncate();

        $faker = Faker::create('es_EC');

        // Asegura usuarios para usuario_id (si ya tienes usuarios, no crea nada)
        if (User::count() === 0) {
            User::factory()->count(3)->create();
        }

        $usuarios = User::query()->pluck('id')->all();
        $clientes  = Cliente::query()->pluck('id')->all();

        $ivaRate = (float) env('IVA_RATE', 0.15); // ajusta a 0.12 si aplica

        // Para evitar choque por "numero" si tu migración NO tiene default/serial:
        $numero = (int) (Factura::max('numero') ?? 0);

        DB::transaction(function () use ($faker, $usuarios, $clientes, $ivaRate, &$numero) {
            for ($i = 0; $i < 80; $i++) {

                $clienteId = $clientes[array_rand($clientes)];
                $usuarioId = $usuarios[array_rand($usuarios)];

                $estado = $faker->randomElement(['pendiente', 'pagada', 'anulada']);

                // Si tu columna numero es SERIAL con default, puedes NO asignarla.
                // Para cubrir ambos casos, la asigno incrementalmente:
                $numero++;

                $factura = Factura::create([
                    'usuario_id' => $usuarioId,
                    'numero' => $numero,
                    'cliente_id' => $clienteId,
                    'fecha_emision' => $faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
                    'subtotal' => 0,
                    'iva' => 0,
                    'total' => 0,
                    'estado' => $estado,
                ]);

                $lineas = random_int(1, 6);

                $subtotal = 0.0;
                $ivaTotal = 0.0;

                for ($l = 0; $l < $lineas; $l++) {

                    // Busca un producto con stock > 0
                    $producto = Producto::query()
                        ->where('stock', '>', 0)
                        ->inRandomOrder()
                        ->first();

                    if (! $producto) {
                        break; // se acabó stock global
                    }

                    $cantidad = random_int(1, min(5, $producto->stock));
                    if ($cantidad <= 0) {
                        continue;
                    }

                    $precio = (float) $producto->precio_unitario;
                    $lineSubtotal = $cantidad * $precio;
                    $lineIva = round($lineSubtotal * $ivaRate, 2);

                    DetalleFactura::create([
                        'factura_id' => $factura->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio' => round($precio, 2),
                        'iva' => $lineIva,
                    ]);

                    // Descuenta stock
                    $producto->decrement('stock', $cantidad);

                    $subtotal += $lineSubtotal;
                    $ivaTotal += $lineIva;
                }

                $subtotal = round($subtotal, 2);
                $ivaTotal = round($ivaTotal, 2);
                $total = round($subtotal + $ivaTotal, 2);

                $factura->update([
                    'subtotal' => $subtotal,
                    'iva' => $ivaTotal,
                    'total' => $total,
                ]);
            }
        });
    }
}
