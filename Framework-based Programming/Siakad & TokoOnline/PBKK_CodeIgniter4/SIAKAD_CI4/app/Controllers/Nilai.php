<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\MataKuliahModel;
use App\Models\NilaiModel;

class Nilai extends BaseController
{
    public function index()
    {
        return view('nilai/index', [
            'title' => 'Data Nilai',
            'data' => (new NilaiModel())->daftarNilai(),
            'mahasiswa' => (new MahasiswaModel())->findAll(),
            'mataKuliah' => (new MataKuliahModel())->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'mahasiswa_id' => 'required|is_not_unique[mahasiswa.id]',
            'mata_kuliah_id' => 'required|is_not_unique[mata_kuliah.id]',
            'nilai_angka' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $angka = (float) $this->request->getPost('nilai_angka');
        $huruf = $angka >= 85 ? 'A' : ($angka >= 75 ? 'B' : ($angka >= 65 ? 'C' : ($angka >= 50 ? 'D' : 'E')));

        (new NilaiModel())->insert([
            'mahasiswa_id' => $this->request->getPost('mahasiswa_id'),
            'mata_kuliah_id' => $this->request->getPost('mata_kuliah_id'),
            'nilai_angka' => $angka,
            'nilai_huruf' => $huruf,
        ]);

        return redirect()->to('/nilai')->with('success', 'Nilai berhasil disimpan.');
    }
}
