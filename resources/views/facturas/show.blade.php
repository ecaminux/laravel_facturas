@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- Selector de Factura -->
                <div class="mb-4 card">
                    <div class="card-body">
                        <label for="facturaSelect" class="form-label fw-bold">Seleccionar Factura:</label>
                        <select id="facturaSelect" class="form-select" onchange="window.location.href=this.value">
                            <option value="" disabled {{ is_null($factura) ? 'selected' : '' }}>Seleccione una factura
                            </option>
                            @foreach($facturas as $f)
                                <option value="{{ route('facturas.show', $f->id) }}" {{ (isset($factura) && $factura->id == $f->id) ? 'selected' : '' }}>
                                    Factura #{{ $f->numero }} - {{ $f->fecha_emision }} -
                                    {{ $f->cliente->nombre ?? 'Cliente Desconocido' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($factura)
                    <!-- Detalle de Factura -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Factura #{{ $factura->numero }}</h4>
                            <span class="badge bg-light text-dark">{{ strtoupper($factura->estado) }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h6 class="mb-3 text-muted">De:</h6>
                                    <div>
                                        <strong>{{ config('app.name') }}</strong>
                                    </div>
                                    <div>Dirección de la Empresa</div>
                                    <div>Email: contacto@empresa.com</div>
                                </div>

                                <div class="col-sm-6 text-sm-end">
                                    <h6 class="mb-3 text-muted">Para:</h6>
                                    @if($factura->cliente)
                                        <div>
                                            <strong>{{ $factura->cliente->nombre }} {{ $factura->cliente->apellido }}</strong>
                                        </div>
                                        <div>{{ $factura->cliente->direccion }}</div>
                                        <div>{{ $factura->cliente->correo }}</div>
                                        <div>RUC/CI: {{ $factura->cliente->ruc }}</div>
                                    @else
                                        <div class="text-danger">Información del cliente no disponible</div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <div><strong>Fecha de Emisión:</strong> {{ $factura->fecha_emision }}</div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-end">Cantidad</th>
                                            <th class="text-end">Precio Unitario</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($factura->detalles as $detalle)
                                            <tr>
                                                <td>{{ $detalle->producto->nombre ?? 'Producto Eliminado' }}</td>
                                                <td class="text-end">{{ $detalle->cantidad }}</td>
                                                <td class="text-end">${{ number_format($detalle->precio, 2) }}</td>
                                                <td class="text-end fw-bold">
                                                    ${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No hay detalles en esta factura.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-sm-5 ms-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="left"><strong>Subtotal</strong></td>
                                                <td class="text-end">${{ number_format($factura->subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="left"><strong>IVA</strong></td>
                                                <td class="text-end">${{ number_format($factura->iva, 2) }}</td>
                                            </tr>
                                            <tr class="fs-5">
                                                <td class="left"><strong>Total</strong></td>
                                                <td class="text-end fw-bold text-primary">
                                                    ${{ number_format($factura->total, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        Seleccione una factura para ver su detalle.
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection