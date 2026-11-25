<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kategori_id', 'nama', 'deskripsi', 'harga', 'stok', 'gambar'];
    protected $useTimestamps = true;

    public function daftar()
    {
        return $this->select('produk.*, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id', 'left')
            ->findAll();
    }
}
