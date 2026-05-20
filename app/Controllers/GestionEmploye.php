<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\EmployesModel;
use App\Models\SoldesModel;
use App\Models\TypesCongeModel;

class GestionEmploye extends BaseController{
    public function mesDemandes(){
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || empty($sessionEmploye['id'])) {
            return redirect()->to('/');
        }

        $idEmploye = $sessionEmploye['id'];

        try {
            $employeModele = new EmployesModel();
            $congeModele = new CongesModel();

            $donneesEmploye = $employeModele
                ->select('employes.*, departements.nom AS nom_departement')
                ->join('departements', 'departements.id = employes.departement_id', 'left')
                ->find($idEmploye);

            if (! $donneesEmploye) {
                $donneesEmploye = $sessionEmploye;
            }

            $nomCompletEmploye = trim(sprintf('%s %s', $donneesEmploye['prenom'] ?? '', $donneesEmploye['nom'] ?? ''));
            if ($nomCompletEmploye === '') {
                $nomCompletEmploye = trim(sprintf('%s %s', $sessionEmploye['prenom'] ?? '', $sessionEmploye['nom'] ?? ''));
            }

            $initialesEmploye = [];
            $morceauxNom = preg_split('/\s+/', $nomCompletEmploye ?: '');
            if (is_array($morceauxNom)) {
                foreach ($morceauxNom as $morceauNom) {
                    if ($morceauNom !== '') {
                        $initialesEmploye[] = strtoupper(substr($morceauNom, 0, 1));
                    }

                    if (count($initialesEmploye) >= 2) {
                        break;
                    }
                }
            }

            $initialesEmploye = ! empty($initialesEmploye) ? implode('', $initialesEmploye) : 'EM';

            $departementEmploye = $donneesEmploye['nom_departement'] ?? 'Non renseigné';

            $nombreDemandesEnAttente = (new CongesModel())
                ->where('employe_id', $idEmploye)
                ->whereIn('statut', ['en_attente', 'attente'])
                ->countAllResults();

            $toutesLesDemandes = (new CongesModel())
                ->select('conges.*, types_conge.libelle AS libelle_type')
                ->join('types_conge', 'types_conge.id = conges.type_conge_id', 'left')
                ->where('conges.employe_id', $idEmploye)
                ->orderBy('conges.date_debut', 'DESC')
                ->get()
                ->getResultArray();

            $donneesVue = [
                'title' => 'Mes demandes',
                'nomEmploye' => $nomCompletEmploye !== '' ? $nomCompletEmploye : 'Utilisateur',
                'departementEmploye' => $departementEmploye,
                'initialesEmploye' => $initialesEmploye,
                'nombreDemandesEnAttente' => $nombreDemandesEnAttente,
                'toutesLesDemandes' => $toutesLesDemandes,
            ];
        } catch (\Exception $e) {
            $donneesVue = [
                'title' => 'Mes demandes',
                'nomEmploye' => $sessionEmploye['prenom'] ?? '' . ' ' . $sessionEmploye['nom'] ?? '',
                'departementEmploye' => 'Non renseigné',
                'initialesEmploye' => 'EM',
                'nombreDemandesEnAttente' => 0,
                'toutesLesDemandes' => [],
            ];
        }

        return view('employe/mesDemandes', $donneesVue);
    }

    public function formulaireConge(){
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || empty($sessionEmploye['id'])) {
            return redirect()->to('/');
        }

        $idEmploye = $sessionEmploye['id'];

        try {
            $employeModele = new EmployesModel();
            $typeCongeModele = new TypesCongeModel();
            $congeModele = new CongesModel();

            $donneesEmploye = $employeModele
                ->select('employes.*, departements.nom AS nom_departement')
                ->join('departements', 'departements.id = employes.departement_id', 'left')
                ->find($idEmploye);

            if (! $donneesEmploye) {
                $donneesEmploye = $sessionEmploye;
            }

            $nomCompletEmploye = trim(sprintf('%s %s', $donneesEmploye['prenom'] ?? '', $donneesEmploye['nom'] ?? ''));
            if ($nomCompletEmploye === '') {
                $nomCompletEmploye = trim(sprintf('%s %s', $sessionEmploye['prenom'] ?? '', $sessionEmploye['nom'] ?? ''));
            }

            $initialesEmploye = [];
            $morceauxNom = preg_split('/\s+/', $nomCompletEmploye ?: '');
            if (is_array($morceauxNom)) {
                foreach ($morceauxNom as $morceauNom) {
                    if ($morceauNom !== '') {
                        $initialesEmploye[] = strtoupper(substr($morceauNom, 0, 1));
                    }

                    if (count($initialesEmploye) >= 2) {
                        break;
                    }
                }
            }

            $initialesEmploye = ! empty($initialesEmploye) ? implode('', $initialesEmploye) : 'EM';
            $departementEmploye = $donneesEmploye['nom_departement'] ?? 'Non renseigné';

            $typesConge = $typeCongeModele
                ->orderBy('libelle', 'ASC')
                ->findAll();

            $nombreDemandesEnAttente = $congeModele
                ->where('employe_id', $idEmploye)
                ->whereIn('statut', ['en_attente', 'attente'])
                ->countAllResults();

            $donneesVue = [
                'title' => 'Nouvelle demande',
                'nomEmploye' => $nomCompletEmploye !== '' ? $nomCompletEmploye : 'Utilisateur',
                'departementEmploye' => $departementEmploye,
                'initialesEmploye' => $initialesEmploye,
                'nombreDemandesEnAttente' => $nombreDemandesEnAttente,
                'typesConge' => $typesConge,
            ];
        } catch (\Exception $e) {
            $donneesVue = [
                'title' => 'Nouvelle demande',
                'nomEmploye' => trim(sprintf('%s %s', $sessionEmploye['prenom'] ?? '', $sessionEmploye['nom'] ?? '')),
                'departementEmploye' => 'Non renseigné',
                'initialesEmploye' => 'EM',
                'nombreDemandesEnAttente' => 0,
                'typesConge' => [],
            ];
        }

        return view('employe/nouvelleDemande', $donneesVue);
    }

    public function soumettreConge(){
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || empty($sessionEmploye['id'])) {
            return redirect()->to('/');
        }

        $idEmploye = $sessionEmploye['id'];
        $typeCongeId = $this->request->getPost('type_conge_id');
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');
        $motif = trim($this->request->getPost('motif'));

        $nbJours = 0;
        if ($dateDebut && $dateFin) {
            try {
                $dateDebutObj = new \DateTime($dateDebut);
                $dateFinObj = new \DateTime($dateFin);
                if ($dateFinObj >= $dateDebutObj) {
                    $interval = $dateDebutObj->diff($dateFinObj);
                    $nbJours = $interval->days + 1;
                }
            } catch (\Exception $e) {
                $nbJours = 0;
            }
        }

        $congeModele = new CongesModel();
        $donneesConge = [
            'employe_id' => $idEmploye,
            'type_conge_id' => $typeCongeId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'nb_jours' => $nbJours,
            'motif' => $motif,
            'statut' => 'en_attente',
        ];

        if ($congeModele->insert($donneesConge)) {
            return redirect()->to('employe/mes-demandes')->with('success', 'Votre demande a été soumise avec succès.');
        } else {
            $errors = implode(', ', $congeModele->errors());
            return redirect()->to('employe/nouvelle-demande')->withInput()->with('error', "Erreur lors de la soumission de votre demande : " . $errors);
        }
    }
    

    public function dashboard(){
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || empty($sessionEmploye['id'])) {
            return redirect()->to('/');
        }

        $idEmploye = $sessionEmploye['id'];

        try {
            $employeModele = new EmployesModel();

            $donneesEmploye = $employeModele
                ->select('employes.*, departements.nom AS nom_departement')
                ->join('departements', 'departements.id = employes.departement_id', 'left')
                ->find($idEmploye);

            if (! $donneesEmploye) {
                $donneesEmploye = $sessionEmploye;
            }

            $nomCompletEmploye = trim(sprintf('%s %s', $donneesEmploye['prenom'] ?? '', $donneesEmploye['nom'] ?? ''));
            if ($nomCompletEmploye === '') {
                $nomCompletEmploye = trim(sprintf('%s %s', $sessionEmploye['prenom'] ?? '', $sessionEmploye['nom'] ?? ''));
            }

            $initialesEmploye = [];
            $morceauxNom = preg_split('/\s+/', $nomCompletEmploye ?: '');
            if (is_array($morceauxNom)) {
                foreach ($morceauxNom as $morceauNom) {
                    if ($morceauNom !== '') {
                        $initialesEmploye[] = strtoupper(substr($morceauNom, 0, 1));
                    }

                    if (count($initialesEmploye) >= 2) {
                        break;
                    }
                }
            }

            $initialesEmploye = ! empty($initialesEmploye) ? implode('', $initialesEmploye) : 'EM';

            $departementEmploye = $donneesEmploye['nom_departement'] ?? 'Non renseigné';

            $nombreDemandesEnAttente = (new CongesModel())
                ->where('employe_id', $idEmploye)
                ->whereIn('statut', ['en_attente', 'attente'])
                ->countAllResults();

            $nombreDemandesApprouvees = (new CongesModel())
                ->where('employe_id', $idEmploye)
                ->whereIn('statut', ['accepte', 'approuve', 'approuvee'])
                ->countAllResults();

            $nombreDemandesRefusees = (new CongesModel())
                ->where('employe_id', $idEmploye)
                ->whereIn('statut', ['refuse', 'refusee'])
                ->countAllResults();

            $resultatAnnee = (new SoldesModel())
                ->selectMax('annee', 'annee_maximale')
                ->where('employe_id', $idEmploye)
                ->get()
                ->getRowArray();

            $anneeMaximale = $resultatAnnee['annee_maximale'] ?? null;
            if ($anneeMaximale === null || $anneeMaximale === '') {
                $anneeMaximale = date('Y');
            }

            $anneeSolde = $anneeMaximale;


            $soldeCumule = (new SoldesModel())
                ->selectSum('jours_attribues', 'total_jours_attribues')
                ->selectSum('jours_pris', 'total_jours_pris')
                ->where('employe_id', $idEmploye)
                ->where('annee', $anneeSolde)
                ->get()
                ->getRowArray();

            $joursAttribuesTotal = $soldeCumule['total_jours_attribues'] ?? 0;
            $joursPrisTotal = $soldeCumule['total_jours_pris'] ?? 0;
            $joursRestantsTotal = max(0, $joursAttribuesTotal - $joursPrisTotal);

            $soldesEmploye = (new SoldesModel())
                ->select('soldes.*, types_conge.libelle AS libelle_type, types_conge.jours_annuels, types_conge.deductible')
                ->join('types_conge', 'types_conge.id = soldes.type_conge_id', 'left')
                ->where('soldes.employe_id', $idEmploye)
                ->where('soldes.annee', $anneeSolde)
                ->orderBy('soldes.type_conge_id', 'ASC')
                ->get()
                ->getResultArray();

            $dernieresDemandes = (new CongesModel())
                ->select('conges.*, types_conge.libelle AS libelle_type')
                ->join('types_conge', 'types_conge.id = conges.type_conge_id', 'left')
                ->where('conges.employe_id', $idEmploye)
                ->orderBy('conges.created_at', 'DESC')
                ->limit(3)
                ->get()
                ->getResultArray();

            $totalDemandesParType = (new CongesModel())
                ->select('types_conge.libelle AS type_conge_nom, COUNT(conges.id) AS total_demandes')
                ->join('types_conge', 'types_conge.id = conges.type_conge_id', 'left')
                ->where('conges.employe_id', $idEmploye)
                ->groupBy('conges.type_conge_id')
                ->get()
                ->getResultArray();

            $donneesVue = [
                'title' => 'Tableau de bord',
                'nomEmploye' => $nomCompletEmploye !== '' ? $nomCompletEmploye : 'Utilisateur',
                'departementEmploye' => $departementEmploye,
                'initialesEmploye' => $initialesEmploye,
                'nombreDemandesEnAttente' => $nombreDemandesEnAttente,
                'nombreDemandesApprouvees' => $nombreDemandesApprouvees,
                'nombreDemandesRefusees' => $nombreDemandesRefusees,
                'joursAttribuesTotal' => $joursAttribuesTotal,
                'joursPrisTotal' => $joursPrisTotal,
                'joursRestantsTotal' => $joursRestantsTotal,
                'anneeSolde' => $anneeSolde,
                'soldesEmploye' => $soldesEmploye,
                'dernieresDemandes' => $dernieresDemandes,
                'totalDemandesParType' => $totalDemandesParType,
            ];
        } catch (\Exception $e) {
            $donneesVue = [
                'title' => 'Tableau de bord',
                'nomEmploye' => $sessionEmploye['prenom'] ?? '' . ' ' . $sessionEmploye['nom'] ?? '',
                'departementEmploye' => 'Non renseigné',
                'initialesEmploye' => 'EM',
                'nombreDemandesEnAttente' => 0,
                'nombreDemandesApprouvees' => 0,
                'nombreDemandesRefusees' => 0,
                'joursAttribuesTotal' => 0,
                'joursPrisTotal' => 0,
                'joursRestantsTotal' => 0,
                'anneeSolde' => date('Y'),
                'soldesEmploye' => [],
                'dernieresDemandes' => [],
                'totalDemandesParType' => [],
            ];
        }

        return view('employe/dashboard', $donneesVue);
    }

    public function calendrier(){
        $sessionEmploye = session()->get('user');

        if (! $sessionEmploye || empty($sessionEmploye['id'])) {
            return redirect()->to('/');
        }

        $idEmploye = $sessionEmploye['id'];

        try {
            $employeModele = new EmployesModel();
            $congeModele = new CongesModel();

            $donneesEmploye = $employeModele
                ->select('employes.*, departements.nom AS nom_departement')
                ->join('departements', 'departements.id = employes.departement_id', 'left')
                ->find($idEmploye);

            if (! $donneesEmploye) {
                $donneesEmploye = $sessionEmploye;
            }

            $nomCompletEmploye = trim(sprintf('%s %s', $donneesEmploye['prenom'] ?? '', $donneesEmploye['nom'] ?? ''));
            if ($nomCompletEmploye === '') {
                $nomCompletEmploye = trim(sprintf('%s %s', $sessionEmploye['prenom'] ?? '', $sessionEmploye['nom'] ?? ''));
            }

            $initialesEmploye = [];
            $morceauxNom = preg_split('/\s+/', $nomCompletEmploye ?: '');
            if (is_array($morceauxNom)) {
                foreach ($morceauxNom as $morceauNom) {
                    if ($morceauNom !== '') {
                        $initialesEmploye[] = strtoupper(substr($morceauNom, 0, 1));
                    }

                    if (count($initialesEmploye) >= 2) {
                        break;
                    }
                }
            }

            $congesEtendus = $congeModele
                ->select('conges.*, types_conge.libelle AS type_conge_nom')
                ->join('types_conge', 'types_conge.id = conges.type_conge_id', 'left')
                ->where('employe_id', $idEmploye)
                ->findAll();

            $nombreDemandesEnAttente = $congeModele
                ->where('employe_id', $idEmploye)
                ->where('statut', 'en_attente')
                ->countAllResults();

            return view('employe/calendrier', [
                'title' => 'Mon Calendrier - TechMada',
                'conges' => $congesEtendus,
                'nomEmploye' => $nomCompletEmploye,
                'departementEmploye' => $donneesEmploye['nom_departement'] ?? '',
                'initialesEmploye' => implode('', $initialesEmploye),
                'nombreDemandesEnAttente' => $nombreDemandesEnAttente
            ]);
        } catch (\Exception $e) {
            log_message('error', '[ERREUR GESTION EMPLOYE - Calendrier] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
        }
    }
}
?>