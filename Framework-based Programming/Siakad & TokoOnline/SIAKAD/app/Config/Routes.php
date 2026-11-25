<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = Services::routes();

$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('mahasiswa', 'Mahasiswa::index');
$routes->get('mahasiswa/tambah', 'Mahasiswa::create');
$routes->post('mahasiswa/simpan', 'Mahasiswa::store');
$routes->get('mahasiswa/edit/(:num)', 'Mahasiswa::edit/$1');
$routes->post('mahasiswa/update/(:num)', 'Mahasiswa::update/$1');
$routes->get('mahasiswa/hapus/(:num)', 'Mahasiswa::delete/$1');
$routes->get('mata-kuliah', 'MataKuliah::index');
$routes->post('mata-kuliah/simpan', 'MataKuliah::store');
$routes->get('nilai', 'Nilai::index');
$routes->post('nilai/simpan', 'Nilai::store');
