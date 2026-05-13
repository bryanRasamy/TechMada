<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('DepartementsSeeder');
        $this->call('TypesCongeSeeder');
        $this->call('EmployesSeeder');
        $this->call('SoldesSeeder');
    }
}
