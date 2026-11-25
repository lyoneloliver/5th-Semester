<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class HomeController extends BaseController
{
    public function index()
    {
        $categories = (new CategoryModel())
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $products = (new ProductModel())
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->findAll(8);

        return view('frontend/home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
