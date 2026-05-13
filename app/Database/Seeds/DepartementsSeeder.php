<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartementsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nom'         => 'Informatique',
                'description' => 'Département chargé de la gestion des SI et du développement logiciel.',
            ],
            [
                'nom'         => 'Ressources Humaines',
                'description' => 'Département responsable de la gestion du personnel, du recrutement et des relations sociales.',
            ],
            [
                'nom'         => 'Production',
                'description' => 'Département responsable de la fabrication des produits, de la gestion des opérations et de la logistique.',
            ],
        ];

        $this->db->table('departements')->insertBatch($data);
    }
}
