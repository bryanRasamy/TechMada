<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCongesTable extends Migration
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
            'date_debut' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'date_fin' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nb_jours' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'motif' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'statut' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'commentaire_rh' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'traite_par' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('employe_id', 'employes', 'id', '', 'SET NULL');
        $this->forge->addForeignKey('type_conge_id', 'types_conge', 'id', '', 'SET NULL');
        $this->forge->addForeignKey('traite_par', 'employes', 'id', '', 'SET NULL');
        $this->forge->createTable('conges');
    }

    public function down()
    {
        $this->forge->dropTable('conges');
    }
}
