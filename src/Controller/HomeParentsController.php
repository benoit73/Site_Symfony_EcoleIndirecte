<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeParentsController extends AbstractController
{
    #[Route('/home/parents', name: 'app_home_parents')]
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user->getParents() === null) {
            return $this->redirectToRoute('app_home_student');
        } 
        return $this->render('home_parents/index.html.twig', [
            'controller_name' => 'HomeParentsController',
        ]);
    }
}
