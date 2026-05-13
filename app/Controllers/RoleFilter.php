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
        $arguments=['admin', 'rh'];
        
        if (!$user || !in_array($user['role'], $arguments ?? [])) {
            return redirect()->back()->with('error', 'Accès refusé : droits insuffisants');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }
}
