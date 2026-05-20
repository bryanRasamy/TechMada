<?php

namespace App\Controllers;

use App\Models\EmployesModel;

class GestionUser extends BaseController{
    public function index(){
        $data = [
            'title' => 'Login',
        ];

        return view('login', $data);
    }

    public function authentifier(){
        $employeModel = new EmployesModel();

        $email = $this->request->getVar('email');
        $mot_de_passe = $this->request->getVar('password');

        if (empty($email) || empty($mot_de_passe)) {
            $errorMsg = 'Email et mot de passe requis.';
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        $employer = $employeModel->where('email', $email)->first();

        $isPasswordValid = false;
        if ($employer) {
            if (password_verify($mot_de_passe, $employer['password'])) {
                $isPasswordValid = true;
            }
        }

        if ($isPasswordValid) {
            session()->set('user', [
                'id'   => $employer['id'],
                'nom'       => $employer['nom'],
                'prenom'    => $employer['prenom'],
                'email'     => $employer['email'],
                'role'      => $employer['role'],
                'departement_id' => $employer['departement_id'],
                'date_embauche' => $employer['date_embauche'],
                'actif' => $employer['actif']
            ]);

            // Redirection selon le rôle
            $urlRedirection = 'employe/dashboard';
            if ($employer['role'] === 'admin') {
                $urlRedirection = 'admin/dashboard';
            } elseif ($employer['role'] === 'rh') {
                $urlRedirection = 'rh/dashboard';
            }

            return redirect()->to($urlRedirection)->with('success', 'Connexion réussie.');
        }

        $errorMsg = 'Email ou mot de passe incorrect.';
        return redirect()->back()->withInput()->with('error', $errorMsg);
    }


    public function deconnexion(){
        session()->destroy();
        return redirect()->to('/')->with('success', 'Déconnexion réussie.');
    }
}
