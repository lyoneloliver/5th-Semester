<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = Services::routes();

$routes->get('/', 'Produk::index');
$routes->get('produk', 'Produk::index');
$routes->get('produk/(:num)', 'Produk::detail/$1');
$routes->get('keranjang', 'Keranjang::index');
$routes->post('keranjang/tambah/(:num)', 'Keranjang::tambah/$1');
$routes->post('keranjang/update', 'Keranjang::update');
$routes->get('keranjang/hapus/(:num)', 'Keranjang::hapus/$1');
$routes->post('checkout', 'Pesanan::checkout');
$routes->get('pesanan/selesai/(:num)', 'Pesanan::selesai/$1');
$routes->get('admin', 'Admin::index');
$routes->post('admin/produk/simpan', 'Admin::simpanProduk');
$routes->get('admin/produk/hapus/(:num)', 'Admin::hapusProduk/$1');
