<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypesCongeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'libelle'       => 'Congé annuel',
                'jours_annuels' => 30,
                'deductible'    => 0,
            ],
            [
                'libelle'       => 'Congé maladie',
                'jours_annuels' => 20,
                'deductible'    => 1,
            ],
            [
                'libelle'       => 'Congé spécial',
                'jours_annuels' => 90,
                'deductible'    => 1,
            ],
        ];

        $this->db->table('types_conge')->insertBatch($data);
    }
}
