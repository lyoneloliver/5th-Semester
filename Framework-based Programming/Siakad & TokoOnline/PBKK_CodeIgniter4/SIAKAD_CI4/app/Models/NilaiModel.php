<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mahasiswa_id', 'mata_kuliah_id', 'nilai_angka', 'nilai_huruf'];
    protected $useTimestamps = true;

    public function daftarNilai()
    {
        return $this->select('nilai.*, mahasiswa.nim, mahasiswa.nama AS nama_mahasiswa, mata_kuliah.kode, mata_kuliah.nama AS nama_mk')
            ->join('mahasiswa', 'mahasiswa.id = nilai.mahasiswa_id')
            ->join('mata_kuliah', 'mata_kuliah.id = nilai.mata_kuliah_id')
            ->findAll();
    }
}
