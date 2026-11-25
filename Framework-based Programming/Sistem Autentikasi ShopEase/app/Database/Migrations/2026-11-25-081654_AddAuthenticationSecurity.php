<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthenticationSecurity extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'session_version' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 1,
                'after' => 'is_active',
            ],
            'last_login_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'session_version',
            ],
        ]);

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'selector' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'validator_hash' => [
                'type' => 'CHAR',
                'constraint' => 64,
            ],
            'device_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'last_used_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('selector');
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->createTable('token_ingat');

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'reason' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('created_at');
        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'SET NULL',
            'CASCADE'
        );
        $this->forge->createTable('log_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('log_masuk', true);
        $this->forge->dropTable('token_ingat', true);

        $this->forge->dropColumn('users', [
            'session_version',
            'last_login_at',
        ]);
    }
}
