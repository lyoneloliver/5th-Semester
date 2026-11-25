<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;

class MataKuliah extends BaseController
{
    public function index()
    {
        return view('matakuliah/index', [
            'title' => 'Mata Kuliah',
            'data' => (new MataKuliahModel())->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'kode' => 'required|is_unique[mata_kuliah.kode]',
            'nama' => 'required',
            'sks' => 'required|integer|greater_than[0]|less_than_equal_to[6]',
            'semester' => 'required|integer|greater_than[0]|less_than_equal_to[14]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        (new MataKuliahModel())->insert($this->request->getPost(['kode', 'nama', 'sks', 'semester']));
        return redirect()->to('/mata-kuliah')->with('success', 'Mata kuliah ditambahkan.');
    }
}
