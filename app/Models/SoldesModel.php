<?php
namespace App\Models;

use CodeIgniter\Model;

class SoldesModel extends Model{
    protected $table = 'soldes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'employe_id',
        'type_conge_id',
        'annee',
        'jours_attribues',
        'jours_pris'
    ];

    protected $validationRules = [
        'employe_id' => 'required|integer',
        'type_conge_id' => 'required|integer',
        'annee' => 'required|integer',
        'jours_attribues' => 'required|integer',
        'jours_pris' => 'required|integer'
    ];

}