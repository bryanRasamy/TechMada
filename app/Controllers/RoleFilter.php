<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null){
        $session = session();
        $user = $session->get('user');
        
        // Si aucun argument n'est fourni, on autorise admin par défaut ou selon le besoin
        if (empty($arguments)) {
            $arguments = ['admin'];
        }
        
        if (!$user || !in_array($user['role'], $arguments)) {
            return redirect()->back()->with('error', 'Accès refusé : droits insuffisants');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }
}
