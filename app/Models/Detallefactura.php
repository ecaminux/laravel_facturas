<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detallefactura extends Model
{
    protected $table = 'detalle_factura';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}
