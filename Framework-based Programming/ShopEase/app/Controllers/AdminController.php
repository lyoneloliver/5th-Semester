<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('user_role') !== 'admin') {
            return redirect()->to(site_url('login'))->with('error', 'Silakan login sebagai admin.');
        }

        return view('admin/dashboard', [
            'productCount' => (new ProductModel())->countAll(),
            'customerCount' => (new UserModel())->where('role', 'customer')->countAllResults(),
        ]);
    }
}
