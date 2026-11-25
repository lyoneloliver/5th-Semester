<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenIngatModel extends Model
{
    protected $table = 'token_ingat';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'selector',
        'validator_hash',
        'device_name',
        'user_agent',
        'ip_address',
        'expires_at',
        'created_at',
        'last_used_at',
    ];

    protected $useTimestamps = false;
}
