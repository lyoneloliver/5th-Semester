<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_pelanggan', 'email', 'alamat', 'total', 'status'];
    protected $useTimestamps = true;
}
