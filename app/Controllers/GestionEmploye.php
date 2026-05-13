<?php

namespace App\Controllers;

use App\Models\EmployesModel;

class GestionEmploye extends BaseController{
    public function mesDemandes(){
        return view('mesDemandes');
    }

    public function dashboard(){
        return view('dashboard');
    }
}
?>