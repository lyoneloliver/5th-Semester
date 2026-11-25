<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        return view('produk/index', [
            'title' => 'Toko Online',
            'produk' => (new ProdukModel())->daftar(),
        ]);
    }

    public function detail($id)
    {
        $produk = (new ProdukModel())->find($id);
        if (!$produk) {
            return redirect()->to('/produk')->with('error', 'Produk tidak ditemukan.');
        }
        return view('produk/detail', ['title' => $produk['nama'], 'produk' => $produk]);
    }
}
