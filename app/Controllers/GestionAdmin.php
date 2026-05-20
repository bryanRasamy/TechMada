<?php
namespace App\Controllers;

use App\Models\EmployesModel;
use App\Models\DepartementsModel;
use App\Models\TypesCongeModel;

class GestionAdmin extends BaseController {

    public function employes() {
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || $sessionEmploye['role'] !== 'admin') {
            return redirect()->to('/');
        }

        $employeModele = new EmployesModel();
        $departementModele = new DepartementsModel();

        // Récupérer la liste de tous les employés, ainsi que le nom de leur département
        $employes = $employeModele
            ->select('employes.*, departements.nom AS nom_departement')
            ->join('departements', 'departements.id = employes.departement_id', 'left')
            ->orderBy('employes.id', 'DESC')
            ->findAll();

        $departements = $departementModele->findAll();

        $donneesVue = [
            'title' => 'Gestion des employés',
            'employes' => $employes,
            'departements' => $departements,
            'nomEmploye' => trim(($sessionEmploye['prenom'] ?? '') . ' ' . ($sessionEmploye['nom'] ?? '')),
            'departementEmploye' => 'Administration',
            'initialesEmploye' => 'AD' // Par défaut on met AD pour l'admin
        ];

        return view('admin/employes', $donneesVue);
    }

    public function ajouterEmploye() {
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || $sessionEmploye['role'] !== 'admin') {
            return redirect()->to('/');
        }

        $employeModele = new EmployesModel();
        
        $donnees = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'departement_id' => $this->request->getPost('departement_id'),
            'role' => $this->request->getPost('role'),
            'date_embauche' => $this->request->getPost('date_embauche'),
            'actif' => 1
        ];

        if ($employeModele->insert($donnees)) {
            // OPTIONNEL: initialiser compte soldes etc.
            return redirect()->to('admin/employes')->with('success', 'Employé ajouté avec succès !');
        } else {
            $errors = implode(', ', $employeModele->errors());
            return redirect()->to('admin/employes')->with('error', "Erreur lors de l'ajout de l'employé : " . $errors);
        }
    }
    public function departements() {
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || $sessionEmploye['role'] !== 'admin') {
            return redirect()->to('/');
        }

        $departementModele = new DepartementsModel();
        $departements = $departementModele->findAll();

        $donneesVue = [
            'title' => 'Gestion des Départements',
            'departements' => $departements,
            'nomEmploye' => trim(($sessionEmploye['prenom'] ?? '') . ' ' . ($sessionEmploye['nom'] ?? '')),
            'departementEmploye' => 'Administration',
            'initialesEmploye' => 'AD'
        ];

        return view('admin/departements', $donneesVue);
    }

    public function ajouterDepartement() {
        $departementModele = new DepartementsModel();
        
        $donnees = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description')
        ];

        if ($departementModele->insert($donnees)) {
            return redirect()->to('admin/departements')->with('success', 'Département ajouté avec succès !');
        } else {
            $errors = implode(', ', $departementModele->errors());
            return redirect()->to('admin/departements')->with('error', "Erreur lors de l'ajout du département : " . $errors);
        }
    }

    public function typesConges() {
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || $sessionEmploye['role'] !== 'admin') {
            return redirect()->to('/');
        }

        $typesCongeModele = new TypesCongeModel();
        $typesConges = $typesCongeModele->findAll();

        $donneesVue = [
            'title' => 'Types de congés',
            'types_conges' => $typesConges,
            'nomEmploye' => trim(($sessionEmploye['prenom'] ?? '') . ' ' . ($sessionEmploye['nom'] ?? '')),
            'departementEmploye' => 'Administration',
            'initialesEmploye' => 'AD'
        ];

        return view('admin/types_conges', $donneesVue);
    }

    public function ajouterTypeConge() {
        $typesCongeModele = new TypesCongeModel();
        
        $donnees = [
            'libelle' => $this->request->getPost('libelle'),
            'jours_annuels' => $this->request->getPost('jours_annuels') ?: null,
            'deductible' => $this->request->getPost('deductible')
        ];

        if ($typesCongeModele->insert($donnees)) {
            return redirect()->to('admin/types-conge')->with('success', 'Type de congé ajouté avec succès !');
        } else {
            $errors = implode(', ', $typesCongeModele->errors());
            return redirect()->to('admin/types-conge')->with('error', "Erreur lors de l'ajout : " . $errors);
        }
    }
    public function dashboard() {
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || $sessionEmploye['role'] !== 'admin') {
            return redirect()->to('/');
        }

        $employeModele = new EmployesModel();
        $departementModele = new DepartementsModel();

        // Récupérer quelques statistiques pour le dashboard
        $totalEmployes = $employeModele->countAllResults();
        $totalDepartements = $departementModele->countAllResults();

        $donneesVue = [
            'title' => 'Vue d\'ensemble Administration',
            'totalEmployes' => $totalEmployes,
            'totalDepartements' => $totalDepartements,
            'nomEmploye' => trim(($sessionEmploye['prenom'] ?? '') . ' ' . ($sessionEmploye['nom'] ?? '')),
            'departementEmploye' => 'Administration',
            'initialesEmploye' => 'AD'
        ];

        return view('admin/dashboard', $donneesVue);
    }
}
