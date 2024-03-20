<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse; 

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user->getEleve() != null) {
            return $this->redirectToRoute('app_home_student');
        }   
        elseif ($user->getParents() != null) {
            return $this->redirectToRoute('app_home_parents');
        }        
        else{
            return $this->redirectToRoute('app_logout');

        }
        
    }

    #[Route('/', name: 'redirectToHome')]
    public function redirectToHome(): RedirectResponse
    {
        return $this->redirectToRoute('app_home');
    }
}
