<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'prenom' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'departement_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'date_embauche' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'actif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 1,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('departement_id', 'departements', 'id', '', 'SET NULL');
        $this->forge->createTable('employes');
    }

    public function down()
    {
        $this->forge->dropTable('employes');
    }
}
