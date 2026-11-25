<?php

namespace App\Models;

use CodeIgniter\Model;

class LogMasukModel extends Model
{
    protected $table = 'log_masuk';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'status',
        'reason',
        'created_at',
    ];

    protected $useTimestamps = false;
}
