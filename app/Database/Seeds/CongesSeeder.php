<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CongesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'employe_id' => 1,
                'type_conge_id' => 1,
                'date_debut' => '2026-06-01',
                'date_fin' => '2026-06-10',
                'nb_jours' => 10,
                'motif' => 'Vacances d\'été',
                'statut' => 'en_attente'
            ],
            [
                'employe_id' => 2,
                'type_conge_id' => 2,
                'date_debut' => '2026-07-15',
                'date_fin' => '2026-07-20',
                'nb_jours' => 5,
                'motif' => 'Grippe',
                'statut' => 'approuvée'
            ],
            [
                'employe_id' => 3,
                'type_conge_id' => 3,
                'date_debut' => '2026-08-01',
                'date_fin' => '2026-08-30',
                'nb_jours' => 20,
                'motif' => 'Voyage',
                'statut' => 'en_attente'
            ],
        ];

        $this->db->table('conges')->insertBatch($data);
    }
}