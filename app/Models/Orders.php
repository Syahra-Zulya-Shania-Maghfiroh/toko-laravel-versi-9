<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public $timestamps = false;
    protected $fillable = ['id_customers', 'id_petugas', 'tgl_transaksi'];
}
