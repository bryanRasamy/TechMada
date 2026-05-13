<?php
namespace App\Models;

use CodeIgniter\Model;

class EmployesModel extends Model{
    protected $table = 'employes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'departement_id',
        'date_embauche',
        'actif'
    ];

    protected $validationRules = [
        'nom' => 'required|max_length[255]',
        'prenom' => 'required|max_length[255]',
        'email' => 'required|valid_email|is_unique[employes.email]',
        'password' => 'required|min_length[8]',
        'role' => 'required|in_list[admin,employee]',
        'departement_id' => 'required|integer',
        'date_embauche' => 'required|date',
        'actif' => 'permit_empty|in_list[0,1]'
    ];
}