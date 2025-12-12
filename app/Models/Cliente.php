<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * 
 * @property Collection|Factura[] $facturas
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';
	public $incrementing = false;
	public $timestamps = false;

	public function facturas()
	{
		return $this->hasMany(Factura::class);
	}
}
