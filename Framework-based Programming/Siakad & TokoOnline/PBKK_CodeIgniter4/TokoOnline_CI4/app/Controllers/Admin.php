<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;

class Admin extends BaseController
{
    public function index()
    {
        return view('admin/index', [
            'title' => 'Admin Toko Online',
            'produk' => (new ProdukModel())->daftar(),
            'kategori' => (new KategoriModel())->findAll(),
        ]);
    }

    public function simpanProduk()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'kategori_id' => 'required|is_not_unique[kategori.id]',
            'harga' => 'required|decimal|greater_than[0]',
            'stok' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        (new ProdukModel())->insert($this->request->getPost(['kategori_id', 'nama', 'deskripsi', 'harga', 'stok', 'gambar']));
        return redirect()->to('/admin')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function hapusProduk($id)
    {
        (new ProdukModel())->delete($id);
        return redirect()->to('/admin')->with('success', 'Produk dihapus.');
    }
}
