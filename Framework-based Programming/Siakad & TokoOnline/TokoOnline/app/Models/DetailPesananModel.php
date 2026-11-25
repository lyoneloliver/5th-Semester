<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pesanan_id', 'produk_id', 'jumlah', 'harga'];
}
