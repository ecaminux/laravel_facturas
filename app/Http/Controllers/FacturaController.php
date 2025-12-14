<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Muestra la factura especificada.
     *
     * @param  int|null $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id = null)
    {
        // Obtener todas las facturas para el selector
        $facturas = Factura::orderBy('fecha_emision', 'desc')->get();

        // Si no se proporciona ID, intentar encontrar la primera o simplemente mostrar la página del selector
        if (!$id) {
            if ($facturas->count() > 0) {
                return redirect()->route('facturas.show', ['id' => $facturas->first()->id]);
            }
            // Si no existen facturas en absoluto
            return view('facturas.show', ['factura' => null, 'facturas' => $facturas]);
        }

        // Buscar la factura con relaciones
        $factura = Factura::with(['cliente', 'detalles.producto'])->findOrFail($id);

        return view('facturas.show', compact('factura', 'facturas'));
    }
}
