<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use Config\Database;

class Pesanan extends BaseController
{
    public function checkout()
    {
        $rules = [
            'nama_pelanggan' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'alamat' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/keranjang')->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $cart = session()->get('cart') ?? [];
        if (!$cart) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $db = Database::connect();
        $db->transStart();
        $produkModel = new ProdukModel();
        $items = [];
        $total = 0;

        foreach ($cart as $id => $jumlah) {
            $produk = $produkModel->find($id);
            if (!$produk || (int) $produk['stok'] < (int) $jumlah) {
                $db->transRollback();
                return redirect()->to('/keranjang')->with('error', 'Stok produk berubah. Periksa kembali keranjang.');
            }
            $items[] = ['produk' => $produk, 'jumlah' => (int) $jumlah];
            $total += (float) $produk['harga'] * (int) $jumlah;
        }

        $pesananId = (new PesananModel())->insert([
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'total' => $total,
            'status' => 'Menunggu',
        ], true);

        $detailModel = new DetailPesananModel();
        foreach ($items as $item) {
            $detailModel->insert([
                'pesanan_id' => $pesananId,
                'produk_id' => $item['produk']['id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['produk']['harga'],
            ]);
            $produkModel->update($item['produk']['id'], [
                'stok' => (int) $item['produk']['stok'] - $item['jumlah'],
            ]);
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->to('/keranjang')->with('error', 'Pesanan gagal diproses.');
        }

        session()->remove('cart');
        return redirect()->to('/pesanan/selesai/'.$pesananId);
    }

    public function selesai($id)
    {
        $pesanan = (new PesananModel())->find($id);
        if (!$pesanan) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan.');
        }
        return view('pesanan/selesai', ['title' => 'Pesanan Berhasil', 'pesanan' => $pesanan]);
    }
}
