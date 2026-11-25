<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;

class Mahasiswa extends BaseController
{
    private MahasiswaModel $mahasiswa;

    public function __construct()
    {
        $this->mahasiswa = new MahasiswaModel();
    }

    public function index()
    {
        return view('mahasiswa/index', [
            'title' => 'Data Mahasiswa',
            'mahasiswa' => $this->mahasiswa->findAll(),
        ]);
    }

    public function create()
    {
        return view('mahasiswa/form', ['title' => 'Tambah Mahasiswa', 'data' => null]);
    }

    public function store()
    {
        $rules = [
            'nim' => 'required|is_unique[mahasiswa.nim]',
            'nama' => 'required',
            'email' => 'required|valid_email',
            'jurusan' => 'required',
            'angkatan' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->mahasiswa->insert($this->request->getPost(['nim', 'nama', 'email', 'jurusan', 'angkatan']));
        return redirect()->to('/mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = $this->mahasiswa->find($id);
        if (!$data) {
            return redirect()->to('/mahasiswa')->with('error', 'Data tidak ditemukan.');
        }
        return view('mahasiswa/form', ['title' => 'Edit Mahasiswa', 'data' => $data]);
    }

    public function update($id)
    {
        $data = $this->mahasiswa->find($id);
        if (!$data) {
            return redirect()->to('/mahasiswa')->with('error', 'Data tidak ditemukan.');
        }

        $rules = [
            'nim' => "required|is_unique[mahasiswa.nim,id,{$id}]",
            'nama' => 'required',
            'email' => 'required|valid_email',
            'jurusan' => 'required',
            'angkatan' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->mahasiswa->update($id, $this->request->getPost(['nim', 'nama', 'email', 'jurusan', 'angkatan']));
        return redirect()->to('/mahasiswa')->with('success', 'Data mahasiswa diperbarui.');
    }

    public function delete($id)
    {
        $this->mahasiswa->delete($id);
        return redirect()->to('/mahasiswa')->with('success', 'Data mahasiswa dihapus.');
    }
}
