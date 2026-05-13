<?php
namespace App\Models;

use CodeIgniter\Model;

class TypesCongeModel extends Model{
    protected $table = 'types_conge';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'libelle',
        'jours_annuels',
        'deductible'
    ];

    protected $validationRules = [
        'libelle' => 'required|max_length[255]',
        'jours_annuels' => 'permit_empty|integer',
        'deductible' => 'permit_empty|in_list[0,1]'
    ];
}