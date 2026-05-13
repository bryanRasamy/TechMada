<?php
namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model{
    protected $table = 'departements';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom',
        'description'
    ];

    protected $validationRules = [
        'nom' => 'required|max_length[255]',
        'description' => 'permit_empty|max_length[1000]'
    ];
}

