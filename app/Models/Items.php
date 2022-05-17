<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_bill',
        'IDItem',
        'Nombre',
        'Sku',
        'Cantidad',
        'No_Serie',
        'Pedimento',
        'FechaPedimento',
        'Aduana',
        'status'
    ];
}
