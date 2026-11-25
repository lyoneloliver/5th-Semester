<?php

namespace Config;

use App\Libraries\Autentikasi;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function autentikasi(bool $getShared = true): Autentikasi
    {
        if ($getShared) {
            return static::getSharedInstance('autentikasi');
        }

        return new Autentikasi();
    }
}
