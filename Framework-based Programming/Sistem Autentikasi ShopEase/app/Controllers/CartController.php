<?php

namespace App\Controllers;

class CartController extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        return view('frontend/cart', ['cart' => $cart]);
    }
}
