<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') === '1';

        $result = service('autentikasi')->login(
            $email,
            $password,
            $remember
        );

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $result['message']);
        }

        return redirect()->to('/')
            ->with('success', 'Berhasil masuk. Selamat datang!');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'phone' => 'required',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'terms' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $email = strtolower(trim($this->request->getPost('email')));
        $phone = trim($this->request->getPost('phone'));
        $password = $this->request->getPost('password');

        if (
            strlen($password) > 72 ||
            !preg_match('/[A-Za-z]/', $password) ||
            !preg_match('/[0-9]/', $password)
        ) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'password' => 'Password harus terdiri dari 8–72 byte dan mengandung huruf serta angka.',
                ]);
        }

        if (!preg_match('/^(?:\+62|62|0)8[1-9][0-9]{7,11}$/', $phone)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'phone' => 'Format nomor telepon Indonesia tidak valid.',
                ]);
        }

        $users = new UserModel();

        $userId = $users->insert([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password_hash' => $password,
            'role' => 'customer',
            'is_active' => 1,
        ]);

        if (!$userId) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }

        return redirect()->to('/masuk')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function logout()
    {
        service('autentikasi')->logout();

        return redirect()->to('/')
            ->with('success', 'Kamu berhasil keluar.');
    }
}
