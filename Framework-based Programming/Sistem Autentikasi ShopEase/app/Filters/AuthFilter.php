<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('autentikasi');
        $user = $auth->user();

        if (!$user) {
            return redirect()->to('/masuk');
        }

        if ($arguments && !in_array($user['role'], $arguments, true)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 - Anda tidak memiliki akses ke halaman ini.');
        }

        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}
