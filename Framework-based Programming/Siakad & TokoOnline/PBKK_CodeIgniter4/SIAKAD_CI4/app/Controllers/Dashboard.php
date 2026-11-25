<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\MataKuliahModel;
use App\Models\NilaiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard', [
            'title' => 'Dashboard SIAKAD',
            'jumlahMahasiswa' => (new MahasiswaModel())->countAll(),
            'jumlahMataKuliah' => (new MataKuliahModel())->countAll(),
            'jumlahNilai' => (new NilaiModel())->countAll(),
        ]);
    }
}
