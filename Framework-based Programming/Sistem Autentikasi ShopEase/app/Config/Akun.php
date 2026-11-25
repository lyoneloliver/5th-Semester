<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Akun extends BaseConfig
{
    public string $cookieName = 'shopease_remember';

    public int $rememberDays = 30;

    public int $maxAttempts = 5;

    public int $decaySeconds = 60;

    public array $roleLabels = [
        'customer' => 'Pelanggan',
        'admin' => 'Administrator',
        'operator' => 'Operator',
    ];
}
