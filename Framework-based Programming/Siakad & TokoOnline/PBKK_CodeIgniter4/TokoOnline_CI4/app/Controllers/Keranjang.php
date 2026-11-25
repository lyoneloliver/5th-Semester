<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Keranjang extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        $ids = array_keys($cart);
        $produk = $ids ? (new ProdukModel())->whereIn('id', $ids)->findAll() : [];
        $items = [];
        $total = 0;

        foreach ($produk as $p) {
            $jumlah = (int) $cart[$p['id']];
            $subtotal = $jumlah * (float) $p['harga'];
            $items[] = ['produk' => $p, 'jumlah' => $jumlah, 'subtotal' => $subtotal];
            $total += $subtotal;
        }

        return view('keranjang/index', ['title' => 'Keranjang', 'items' => $items, 'total' => $total]);
    }

    public function tambah($id)
    {
        $produk = (new ProdukModel())->find($id);
        if (!$produk || (int) $produk['stok'] < 1) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = session()->get('cart') ?? [];
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        if ($cart[$id] > (int) $produk['stok']) {
            $cart[$id] = (int) $produk['stok'];
        }
        session()->set('cart', $cart);
        return redirect()->to('/keranjang')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update()
    {
        $cart = session()->get('cart') ?? [];
        foreach ($this->request->getPost('jumlah') ?? [] as $id => $jumlah) {
            $produk = (new ProdukModel())->find($id);
            if ($produk) {
                $jumlah = max(0, min((int) $jumlah, (int) $produk['stok']));
                if ($jumlah === 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id] = $jumlah;
                }
            }
        }
        session()->set('cart', $cart);
        return redirect()->to('/keranjang')->with('success', 'Keranjang diperbarui.');
    }

    public function hapus($id)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$id]);
        session()->set('cart', $cart);
        return redirect()->to('/keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }
}
