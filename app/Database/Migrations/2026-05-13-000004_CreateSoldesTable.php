<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoldesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'employe_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'type_conge_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'annee' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'jours_attribues' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'jours_pris' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('employe_id', 'employes', 'id', '', 'SET NULL');
        $this->forge->addForeignKey('type_conge_id', 'types_conge', 'id', '', 'SET NULL');
        $this->forge->createTable('soldes');
    }

    public function down()
    {
        $this->forge->dropTable('soldes');
    }
}
