<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nom'            => 'Administrateur',
                'prenom'         => 'Aina',
                'email'          => 'admin@techmada.mg',
                'password'       => password_hash('admin123', PASSWORD_BCRYPT),
                'role'           => 'admin',
                'departement_id' => 1,
                'date_embauche'  => '2023-01-15',
                'actif'          => 1,
            ],
            [
                'nom'            => 'Responsable RH',
                'prenom'         => 'Jean',
                'email'          => 'rh@techmada.mg',
                'password'       => password_hash('rh123', PASSWORD_BCRYPT),
                'role'           => 'rh',
                'departement_id' => 2,
                'date_embauche'  => '2023-01-15',
                'actif'          => 1,
            ],
            [
                'nom'            => 'Employé',
                'prenom'         => 'Marie',
                'email'          => 'employe@techmada.mg',
                'password'       => password_hash('emp123', PASSWORD_BCRYPT),
                'role'           => 'employe',
                'departement_id' => 3,
                'date_embauche'  => '2023-02-01',
                'actif'          => 1,
            ],
            [
                'nom'            => 'Andrianarivo',
                'prenom'         => 'Paul',
                'email'          => 'paul@techmada.mg',
                'password'       => password_hash('emp456', PASSWORD_BCRYPT),
                'role'           => 'employe',
                'departement_id' => 3,
                'date_embauche'  => '2023-03-01',
                'actif'          => 1,
            ],
        ];

        $this->db->table('employes')->insertBatch($data);
    }
}
