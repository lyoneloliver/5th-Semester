<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
        'email',
        'password_hash',
        'role',
        'phone',
        'is_active',
        'session_version',
        'last_login_at',
    ];

    protected $useTimestamps = true;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password_hash'])) {
            $data['data']['password_hash'] = password_hash(
                $data['data']['password_hash'],
                PASSWORD_BCRYPT
            );
        }

        return $data;
    }
}
