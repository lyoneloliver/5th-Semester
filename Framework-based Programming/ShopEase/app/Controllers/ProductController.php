<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $keyword = $this->request->getGet('q');

        if ($keyword) {
            $model->like('name', $keyword);
        }

        $products = $model->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->paginate(12);

        return view('frontend/products', [
            'products' => $products,
            'pager' => $model->pager,
            'keyword' => $keyword,
        ]);
    }

    public function show($slug)
    {
        $product = (new ProductModel())
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan');
        }

        return view('frontend/product_detail', ['product' => $product]);
    }
}
