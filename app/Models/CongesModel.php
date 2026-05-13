<?php
namespace App\Models;

use CodeIgniter\Model;

class CongesModel extends Model{
    protected $table = 'conges';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'employe_id',
        'type_conge_id',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'statut',
        'commentaire_rh',
        'traite_par'
    ];

    protected $validationRules = [
        'employe_id' => 'required|integer',
        'type_conge_id' => 'required|integer',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal[date_debut]',
        'nb_jours' => 'required|integer',
        'motif' => 'required|max_length[255]',
        'statut' => 'permit_empty|in_list[en_attente,accepte,refuse]',
        'commentaire_rh' => 'permit_empty|max_length[255]',
        'traite_par' => 'permit_empty|integer'
    ];
}