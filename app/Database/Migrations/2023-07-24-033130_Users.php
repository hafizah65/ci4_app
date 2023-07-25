<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use DateTime;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                // 'default'   => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                // 'constraint' => 'TIMESTAMP'
                // 'constraint' => 'CURRENT_TIMESTAMP ON_UPDATE CURRENT_TIMESTAMP'
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
